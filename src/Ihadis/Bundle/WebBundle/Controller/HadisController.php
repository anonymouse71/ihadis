<?php

namespace Ihadis\Bundle\WebBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ajaxray\TagBundle\Entity\Tag;
use Ihadis\Bundle\CoreBundle\Entity\Book;
use Ihadis\Bundle\CoreBundle\Entity\Chapter;
use Ihadis\Bundle\CoreBundle\Entity\Hadith;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\Yaml\Yaml;

/**
 * @Cache(expires="+2 days", public=true)
 */
class HadisController extends BaseController
{
    /**
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function indexAction()
    {
        $books = $this->getPublishedBooks();

        return $this->render('IhadisWebBundle:Hadis:index.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route("/books/{slug}", name="book-details")
     *
     * @return Response
     */
    public function bookAction(Book $book)
    {
        return $this->render('IhadisWebBundle:Hadis:chapters.html.twig', ['book' => $book]);
    }

    /**
     * @Route("/books/{slug}/chapter/{chapter}", name="chapter")
     *
     * @param Book $book Book slug
     * @param integer $chapter Chapter number
     *
     * @return Response
     */
    public function chapterAction(Book $book, $chapter)
    {
        $hadithRepository = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith');
        $bookTree = $hadithRepository->getDetailedTree($book, $chapter);

        return $this->render('@IhadisWeb/Hadis/section.html.twig', [
            'book' => $book,
            'chapter' => $bookTree[0]->getChapters()[0] // First chapter of First Book in result
        ]);
    }

    /**
     * @Route("/books/{slug}/chapter/{chapter}/section/{section}", name="section")
     *
     * @param Book $book Book slug
     * @param integer $chapter Chapter number
     * @param integer $section Section ID
     *
     * @return Response
     */
    public function sectionAction(Book $book, $chapter, $section)
    {
        $hadithRepository = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith');
        $bookTree = $hadithRepository->getDetailedTree($book, $chapter, $section);

        return $this->render('@IhadisWeb/Hadis/section.html.twig', [
            'book' => $book,
            'chapter' => $bookTree[0]->getChapters()[0], // First chapter of First Book in result
            'sections' => $bookTree[0]->getChapters()[0]->getSections() // Sections of first Chapter of First Book in result
        ]);
    }

    /**
     * @Route("/books/{slug}/hadis/{numberPrimary}", name="hadis")
     *
     * @param Book $book Book slug
     *
     * @return Response
     */
    public function hadisAction(Book $book, Hadith $hadis)
    {
        return $this->render('@IhadisWeb/Hadis/section.html.twig', [
            'book'     => $book,
            'chapter'  => $hadis->getChapter(),
            'sections' => [$hadis->getSection()],
            'hadises'  => [$hadis]
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id" = "\d+"}, name="direct-hadis")
     *
     * @param Hadith $hadith Hadis Id
     *
     * @return Response
     */
    public function directHadisAction(Hadith $hadith)
    {
        return $this->redirect($this->get('router')->generate('hadis', [
            'slug' => $hadith->getBook()->getSlug(),
            'numberPrimary' => $hadith->getNumberPrimary(),
        ]));
    }

    /**
     * @Route("/search/{keyword}/{page}", name="search", defaults={"page":1})
     *
     * @param $keyword
     * @param $page
     *
     * @return Response
     */
    public function searchAction($keyword, $page)
    {
        $perPage = $this->container->getParameter('search_perPage');

        list($hadiths, $total) = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith')->search($keyword, $page, $perPage);

        return $this->render('@IhadisWeb/Hadis/search.html.twig', array(
            'hadiths'    => $hadiths,
            'total'      => $total,
            'per_page'   => $perPage,
            'keyword'    => $keyword,
            'page'       => $page,
            'page_links' => $this->_pagination($page, ceil($total / $perPage), 'search', $keyword)
        ));
    }

    /**
     * To be embedded in other pages
     *
     * @param null|string $active Slug of active book
     *
     * @return Response
     */
    public function _sidebarAction($active = null)
    {
        return $this->render('@IhadisWeb/partials/_sidebar_tabs.html.twig', [
            'books' => $this->getPublishedBooks(),
            'active' => $active
        ]);
    }

    /**
     * Pagination function
     *
     * @param int $current The current page
     * @param int $pages How many pages there are in total
     * @param string $route
     * @param string $keyword  Need to make the link only
     * @internal param int|string $link Link format (sprintf with one %d parameter)
     * @return array An array of links
     */
    public function _pagination($current, $pages, $route, $keyword)
    {
        $min    = ($current - 3 < $pages && $current - 3 > 0) ? $current - 3 : 1;
        $max    = ($current + 3 > $pages) ? $pages : $current + 3;
        $output = array();

        for ($i = $min; $i <= $max; $i++):
            if ($current == $i):
                $output[] = "<li class='active'><a href='#'>{$i}</a></li>";
            else:
                $output[] = '<li><a href="' . $this->generateUrl($route, array('keyword' => $keyword, 'page' => $i)) . '">' . $i . '</a><li>';
            endif;
        endfor;

        if ($current + 1 < $pages):
            $output[] = '<li><a href="' . $this->generateUrl($route, array('keyword' => $keyword, 'page' => $current + 1)) . '" title="Next">&rsaquo;</a></li>';
            $output[] = '<li><a href="' . $this->generateUrl($route, array('keyword' => $keyword, 'page' => $pages)) . '" title="Last">&raquo;</a></li>';
        endif;

        if ($current - 1 > 0):
            array_unshift($output, '<li><a href="' . $this->generateUrl($route, array('keyword' => $keyword, 'page' => $current - 1)) . '" title="Previous">&lsaquo;</a></li>');
            array_unshift($output, '<li><a href="' . $this->generateUrl($route, array('keyword' => $keyword, 'page' => 1)) . '" title="First">&laquo;</a></li>');
        endif;

        return $output;
    }

    /**
     * @return array|\Ihadis\Bundle\CoreBundle\Entity\Book[]
     */
    protected function getPublishedBooks()
    {
        $books = $this->getDoctrine()->getRepository('IhadisCoreBundle:Book')
                      ->findBy(['published' => true])
        ;
        return $books;
    }
}