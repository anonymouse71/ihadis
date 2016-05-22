<?php

/*
 * This file is part of the iHadis project.
 *
 * (c) Mohammad Emran Hasan <phpfour@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ihadis\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Dashboard Controller
 *
 * @author Mohammad Emran Hasan <phpfour@gmail.com>
 */
class DashboardController extends BaseController
{
    public function indexAction()
    {
        return $this->render('IhadisCoreBundle:Dashboard:index.html.twig', array(
            'user' => $this->getUser()
        ));
    }

    public function toolsAction(Request $request)
    {
        $books = $this->get('ihadis.repository.book')->findAll();
        $chapters = $this->get('ihadis.repository.chapter')->findAll();
        $replaced = null;

        if($request->getMethod() == 'POST') {
            $post = $request->request->all();
            $replaced = $this->getDoctrine()->getRepository('IhadisCoreBundle:Hadith')
                ->replaceWords($post['find'], $post['replacement'], $post['book'], $post['chapter'], $post['locale']);
        }
        return $this->render('IhadisCoreBundle:Dashboard:tools.html.twig', array(
            'books' => $books,
            'chapters' => $chapters,
            'replaced' => $replaced,
            'user' => $this->getUser()
        ));
    }
} 