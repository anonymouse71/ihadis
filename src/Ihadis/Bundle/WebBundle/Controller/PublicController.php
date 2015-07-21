<?php

namespace Ihadis\Bundle\WebBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ajaxray\TagBundle\Entity\Tag;
use Ihadis\Bundle\CoreBundle\Entity\Book;
use Ihadis\Bundle\CoreBundle\Entity\Chapter;
use Ihadis\Bundle\CoreBundle\Entity\Hadith;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class PublicController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction()
    {
        $booklist = $this->getDoctrine()->getRepository('IhadisCoreBundle:Book')->findBy(['published' => true]);
        return $this->render('ui2/home.html.twig', [
            'booklist' => $booklist
        ]);
    }

    /**
     * @Route("/book/{slug}", name="book")
     * @param Book $book
     *
     * @return Response
     */
    public function bookAction(Book $book)
    {
        $chapters = $this->get('ihadis.repository.chapter')->findBy(array(
            'book' => $book
        ));

        return $this->render('ui2/book.html.twig', array(
            'book'     => $book,
            'chapters' => $chapters
        ));
    }

    public function booklistAction()
    {
        $booklist = $this->getDoctrine()->getRepository('IhadisCoreBundle:Book')->findBy(['published' => true]);
        $listItems = '';
        foreach($booklist as $book) {
            $url = $this->get('router')->generate('book', array('slug' => $book->getSlug()));
            $listItems .= "<li><a href=\"$url\">{$book->getTitle()}</a></li>";
        }
        return new Response($listItems);
    }

    public function randomHadisAction($title = "আজকের হাদিস")
    {
        $em = $this->getDoctrine()->getManager();
        $rows = $em->createQuery('SELECT COUNT(h.id) FROM IhadisCoreBundle:Hadith h WHERE h.highlighted = 1')->getSingleScalarResult();
        $limit = 1;
        $offset = max(0, rand(0, $rows - $limit));
        $hadis = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith')->findBy(['highlighted' => true], null, $limit, $offset);
        if(count($hadis)) {
            return $this->render('ui2/partials/random.html.twig', [
                'hadis' => $hadis[0],
                'title' => $title,
            ]);
        } else {
            return new Response('<!-- No highlighted hadis found! So not rendering random hadis -->');
        }

    }
}