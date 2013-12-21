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
} 