<?php

namespace Ihadis\Bundle\CoreBundle\Controller;

use Ihadis\Bundle\CoreBundle\Entity\Hadith;
use Ihadis\Bundle\CoreBundle\Form\Type\ValidityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HadithController extends Controller
{
    protected function prepareResource(Request $request, $resource)
    {
        if ($request->attributes->has('section')) {

            $section = $this->get('ihadis.repository.section')->find($request->attributes->get('section'));

            if ($section) {
                $resource->setSection($section);
                $resource->setChapter($section->getChapter());
                $resource->setBook($section->getBook());
            }

            //$resource->setValidity(Hadith::VALIDITY_SAHIH);
        }

    }

    protected function finalizeResource(Request $request, $resource)
    {
        // Clear translations if body is empty
        $params = $request->request->all();
        if(empty($params['ihadis_hadith']['bodyEnglish'])) {
            $resource->getNewTranslations()->remove('en');
        }
        if(empty($params['ihadis_hadith']['bodyArabic'])) {
            $resource->getNewTranslations()->remove('ar');
        }
    }

    public function formAction(Request $request)
    {
        $config = $this->getConfiguration();
        $resource = $this->createNew();

        // Custom function to allow interception
        $this->prepareResource($request, $resource);

        $form = $this->getForm($resource);

        $view = $this
            ->view()
            ->setTemplate('IhadisCoreBundle:Hadith:_form.html.twig')
            ->setData(array(
                $config->getResourceName() => $resource,
                'form'                     => $form->createView(),
               // 'newValidity'              => $this->createForm(new ValidityType())->createView()
            ))
        ;

        return $this->handleView($view);
    }

    public function successAction()
    {
        return new Response('OK');
    }


}