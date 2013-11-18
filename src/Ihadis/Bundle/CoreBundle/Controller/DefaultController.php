<?php

namespace Ihadis\Bundle\CoreBundle\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('IhadisCoreBundle:Default:index.html.twig');
    }
}