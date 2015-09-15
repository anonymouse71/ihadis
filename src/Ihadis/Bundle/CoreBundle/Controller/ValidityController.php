<?php

namespace Ihadis\Bundle\CoreBundle\Controller;

use Ihadis\Bundle\CoreBundle\Entity\Validity;
use Ihadis\Bundle\CoreBundle\Form\Type\ValidityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as CommonController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidityController extends CommonController
{

    public function createAction(Request $request)
    {
        $validity = new Validity();
        $form = $this->createForm(new ValidityType(), $validity);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($validity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', "Validity created: {$validity->getTitle()}");
                return $this->redirect($_SERVER['HTTP_REFERER'] );
            }
        }

        return $this->render('IhadisCoreBundle:Validity:validityForm.html.twig', [
            'form' => $form->createView()
        ]);
    }
}