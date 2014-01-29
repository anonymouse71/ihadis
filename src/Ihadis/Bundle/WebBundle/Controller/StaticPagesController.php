<?php

namespace Ihadis\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticPagesController extends Controller
{
    public function aboutUsAction()
    {
        return $this->render('IhadisWebBundle:StaticPages:aboutUs.html.twig');
    }

    public function disclaimerAction()
    {
        return $this->render('IhadisWebBundle:StaticPages:disclaimer.html.twig');
    }

    public function joinTeamAction()
    {
        return $this->render('IhadisWebBundle:StaticPages:joinTeam.html.twig');
    }

    public function feedbackAction()
    {
        return $this->render('IhadisWebBundle:StaticPages:feedback.html.twig');
    }

    public function incompleteAction()
    {
        return $this->render('IhadisWebBundle:StaticPages:incomplete.html.twig');
    }


}
