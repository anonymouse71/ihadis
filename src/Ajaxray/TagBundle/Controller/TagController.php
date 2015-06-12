<?php

namespace Ajaxray\TagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class TagController extends Controller
{
    public function cloudAction($size)
    {
        return new JsonResponse(['odhu' => 9, 'taharat' => 3, 'iman' => 2]);
    }

    public function addAction()
    {

        return new JsonResponse(['odhu' => 9, 'taharat' => 3, 'iman' => 2]);
    }
}
