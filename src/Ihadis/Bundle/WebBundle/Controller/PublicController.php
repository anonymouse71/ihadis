<?php

namespace Ihadis\Bundle\WebBundle\Controller;

use Ajaxray\TagBundle\Entity\Tag;
use Ihadis\Bundle\CoreBundle\Entity\Book;
use Ihadis\Bundle\CoreBundle\Entity\Chapter;
use Ihadis\Bundle\CoreBundle\Entity\Hadith;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class PublicController extends BaseController
{
    public function indexAction()
    {
        return $this->render('ui2/home.html.twig');
    }
}