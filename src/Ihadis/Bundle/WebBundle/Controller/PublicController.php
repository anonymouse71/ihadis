<?php

namespace Ihadis\Bundle\WebBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ajaxray\TagBundle\Entity\Tag;
use Ihadis\Bundle\CoreBundle\Entity\Book;
use Ihadis\Bundle\CoreBundle\Entity\Chapter;
use Ihadis\Bundle\CoreBundle\Entity\Hadith;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
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
        return $this->render('ui2/home.html.twig');
    }

    public function randomHadisAction($title = "আজকের হাদিস")
    {
        $em = $this->getDoctrine()->getManager();
        $rows = $em->createQuery('SELECT COUNT(h.id) FROM IhadisCoreBundle:Hadith h WHERE h.highlighted = 1')->getSingleScalarResult();
        $limit = 1;
        $offset = max(0, rand(0, $rows - $limit));
        $hadis = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith')->findBy(['highlighted' => true], null, $limit, $offset);
        return $this->render('ui2/partials/random.html.twig', [
            'hadis' => $hadis[0],
            'title' => $title,
        ]);
    }


}