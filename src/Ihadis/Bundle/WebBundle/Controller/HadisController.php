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
        return $this->render('IhadisWebBundle:Hadis:index.html.twig');
    }

    /**
     * @Route("/books/{slug}", name="book-details")
     *
     * @return Response
     */
    public function bookAction(Book $book)
    {
//        $chapters = $this->get('ihadis.repository.chapter')->findBy(array(
//            'book' => $book
//        ));
//
//        return $this->render('IhadisWebBundle:Default:book.html.twig', array(
//            'page'     => 'book',
//            'book'     => $book,
//            'chapters' => $chapters
//        ));

        return $this->render('IhadisWebBundle:Hadis:chapters.html.twig');
    }

    /**
     * @Route("/books/{slug}/chapters/{id}", name="chapter")
     *
     * @return Response
     */
    public function chapterAction(Book $book, Chapter $chapter)
    {
//        $chapters = $this->get('ihadis.repository.chapter')->findBy(array(
//            'book' => $book
//        ));
//
//        $sections = $this->get('ihadis.repository.section')->findBy(
//            array('chapter' => $chapter),
//            array('sortOrder' => 'asc')
//        );
//
//        $hadithRepository = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith');
//
//        return $this->render('IhadisWebBundle:Default:chapter.html.twig', array(
//            'page'       => 'chapter',
//            'book'       => $book,
//            'chapter'    => $chapter,
//            'chapters'   => $chapters,
//            'sections'   => $sections,
//            'hadithRepo' => $hadithRepository
//        ));
        return $this->render('@IhadisWeb/Hadis/section.html.twig');
    }

    // ================ Dummy ===================

    public function pdfBookAction($bookName)
    {
        $bookList = Yaml::parse(file_get_contents('../app/config/booklist.yml'));
        $book = false;

        if(array_key_exists($bookName, $bookList)) {
            $book = $bookList[$bookName];
        }

        return $this->render('IhadisWebBundle:Default:pdfBook.html.twig', array(
            'name' => $bookName,
            'book' => $book,
        ));
    }

    public function hadithAction(Book $book, Chapter $chapter, $numberPrimary)
    {
        $hadith = $this->get('ihadis.repository.hadith')->findOneBy(array(
            'book' => $book,
            'numberPrimary' => $numberPrimary
        ));

        return $this->_showHadith($book, $chapter, $hadith);
    }

    public function gotoAction(Book $book, $numberPrimary)
    {
        $hadith = $this->get('ihadis.repository.hadith')->findOneBy(array(
            'book' => $book,
            'numberPrimary' => $numberPrimary
        ));

        return $this->_showHadith($book, $hadith->getChapter(), $hadith);
    }

    private function _showHadith(Book $book, Chapter $chapter, Hadith $hadith)
    {
        $chapters = $this->get('ihadis.repository.chapter')->findBy(array(
            'book' => $book
        ));

        $sections = $this->get('ihadis.repository.section')->findBy(array(
            'chapter' => $chapter
        ));

        $hadithRepository = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith');

        return $this->render('IhadisWebBundle:Default:hadith.html.twig', array(
            'page'       => 'chapter',
            'book'       => $book,
            'chapter'    => $chapter,
            'chapters'   => $chapters,
            'sections'   => $sections,
            'hadithRepo' => $hadithRepository,
            'selectedHadith' => $hadith
        ));
    }

    public function searchAction($keyword, $page)
    {
        $perPage = $this->container->getParameter('search_perPage');

        list($hadiths, $total) = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith')->search($keyword, $page, $perPage);

        return $this->render('IhadisWebBundle:Default:search.html.twig', array(
            'hadiths'    => $hadiths,
            'total'      => $total,
            'per_page'   => $perPage,
            'keyword'    => $keyword,
            'page'       => $page,
            'page_links' => $this->_pagination($page, ceil($total / $perPage), 'ihadis_search', $keyword)
        ));
    }

    public function reportAction()
    {
        if ($this->getRequest()->getMethod() == 'POST') {
            $data = $this->getRequest()->request->all();

            $to = $this->container->getParameter('report_email');
            $headers = "From: {$data['email']} \r\n" .
                "Reply-To: {$data['email']} \r\n" .
                'X-Mailer: PHP/' . phpversion();

            @mail($to, 'iHadis Report - '. $data['issue'], $data['comments'], $headers);

            $this->getDoctrine()->getRepository('IhadisCoreBundle:HadithReport')->create($data);
            return new Response('OK');
        }
    }

    public function testAction()
    {
//        $em = $this->getDoctrine()->getManager();
//        $entityClass = $this->container->getParameter('ajaxray_tag.entity');
//        $hadis = $em->find($entityClass, 15);
//
//
//        //$this->get('ajaxray_tag.tagger')->tag($hadis, 'ইমান', true);
//        echo '<pre>';
//        \Doctrine\Common\Util\Debug::dump($hadis);
//        die("\n Died in ". __FILE__ ." at line ". __LINE__);

        return $this->render('ui2/layout.html.twig');
    }

    /**
     * @param $keyword
     * @return string
     */
    private static function _detectLang($keyword)
    {
        if (mb_check_encoding($keyword, 'ASCII')) {
            return 'en';
        } else if (preg_match('/[أ-ي]/ui', $keyword)) {
            return 'ar';
        } else {
            return 'bn';
        }
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
                $output[] = "<span>{$i}</span>";
            else:
                $output[] = '<a href="' . $this->generateUrl($route, array('keyword' => $keyword, 'page' => $i)) . '">' . $i . '</a>';
            endif;
        endfor;

        if ($current + 1 < $pages):
            $output[] = '<a href="' . $this->generateUrl($route, array('keyword' => $keyword, 'page' => $current + 1)) . '" title="Next">&rsaquo;</a>';
            $output[] = '<a href="' . $this->generateUrl($route, array('keyword' => $keyword, 'page' => $pages)) . '" title="Last">&raquo;</a>';
        endif;

        if ($current - 1 > 0):
            array_unshift($output, '<a href="' . $this->generateUrl($route, array('keyword' => $keyword, 'page' => $current - 1)) . '" title="Previous">&lsaquo;</a>');
            array_unshift($output, '<a href="' . $this->generateUrl($route, array('keyword' => $keyword, 'page' => 1)) . '" title="First">&laquo;</a>');
        endif;

        return $output;
    }
}