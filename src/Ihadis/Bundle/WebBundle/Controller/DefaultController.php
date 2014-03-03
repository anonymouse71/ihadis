<?php

namespace Ihadis\Bundle\WebBundle\Controller;

use Ihadis\Bundle\CoreBundle\Entity\Book;
use Ihadis\Bundle\CoreBundle\Entity\Chapter;
use Ihadis\Bundle\CoreBundle\Entity\Hadith;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends BaseController
{

    public function indexAction()
    {
        $booklist = Yaml::parse(file_get_contents('../app/config/booklist.yml'));
        return $this->render('IhadisWebBundle:Default:index.html.twig', array(
            'booklist' => $booklist,
        ));
    }

    public function bookAction(Book $book)
    {
        $chapters = $this->get('ihadis.repository.chapter')->findBy(array(
            'book' => $book
        ));

        return $this->render('IhadisWebBundle:Default:book.html.twig', array(
            'page'     => 'book',
            'book'     => $book,
            'chapters' => $chapters
        ));
    }

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

    public function chapterAction(Book $book, Chapter $chapter)
    {
        $chapters = $this->get('ihadis.repository.chapter')->findBy(array(
            'book' => $book
        ));

        $sections = $this->get('ihadis.repository.section')->findBy(array(
            'chapter' => $chapter
        ));

        $hadithRepository = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith');

        return $this->render('IhadisWebBundle:Default:chapter.html.twig', array(
            'page'       => 'chapter',
            'book'       => $book,
            'chapter'    => $chapter,
            'chapters'   => $chapters,
            'sections'   => $sections,
            'hadithRepo' => $hadithRepository
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
        $hadiths = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith')->search($keyword, $page);

        return $this->render('IhadisWebBundle:Default:search.html.twig', array(
            'hadiths'   => $hadiths,
            'keyword'   => $keyword,
            'page' => $page
        ));

    }

    public function reportAction()
    {
        if ($this->getRequest()->getMethod() == 'POST') {
            $data = $this->getRequest()->request->all();
            $this->getDoctrine()->getRepository('IhadisCoreBundle:HadithReport')->create($data);
            return new Response('OK');
        }
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
}