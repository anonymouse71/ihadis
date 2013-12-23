<?php

namespace Ihadis\Bundle\CoreBundle\Controller;

use Ihadis\Bundle\CoreBundle\Entity\Book;
use Ihadis\Bundle\CoreBundle\Entity\Chapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        return $this->render('IhadisCoreBundle:Default:index.html.twig');
    }

    public function chapterAction(Book $book, Chapter $chapter)
    {
        $sections = $this->get('ihadis.repository.section')->findBy(array(
            'chapter' => $chapter
        ));

        $hadithRepository = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith');

        return $this->render('IhadisCoreBundle:Default:chapter.html.twig', array(
            'book'     => $book,
            'chapter'  => $chapter,
            'sections' => $sections,
            'hadithRepo' => $hadithRepository
        ));
    }
}