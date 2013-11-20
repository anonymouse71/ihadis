<?php

namespace Ihadis\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        return $this->render('IhadisCoreBundle:Default:index.html.twig');
    }
}