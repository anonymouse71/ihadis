<?php

namespace Ihadis\Bundle\WebBundle\Controller;

use Ihadis\Bundle\CoreBundle\Entity\Book;
use Ihadis\Bundle\CoreBundle\Entity\Chapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        return $this->render('IhadisWebBundle:Default:index.html.twig');
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

    public function chapterAction(Book $book, Chapter $chapter)
    {
        $sections = $this->get('ihadis.repository.section')->findBy(array(
            'chapter' => $chapter
        ));

        $hadithRepository = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith');

        return $this->render('IhadisWebBundle:Default:chapter.html.twig', array(
            'page'       => 'chapter',
            'book'       => $book,
            'chapter'    => $chapter,
            'sections'   => $sections,
            'hadithRepo' => $hadithRepository
        ));
    }

    public function hadithAction(Book $book, Chapter $chapter, $numberPrimary)
    {
        $sections = $this->get('ihadis.repository.section')->findBy(array(
            'chapter' => $chapter
        ));

        $hadith = $this->get('ihadis.repository.hadith')->findOneBy(array(
            'book' => $book,
            'numberPrimary' => $numberPrimary
        ));

        $hadithRepository = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith');

        return $this->render('IhadisWebBundle:Default:hadith.html.twig', array(
            'page'       => 'chapter',
            'book'       => $book,
            'chapter'    => $chapter,
            'sections'   => $sections,
            'hadithRepo' => $hadithRepository,
            'selectedHadith' => $hadith
        ));
    }
}