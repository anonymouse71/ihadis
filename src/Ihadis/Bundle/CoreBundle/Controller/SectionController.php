<?php

namespace Ihadis\Bundle\CoreBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SectionController extends ResourceController
{
    /**
     * Create new resource or just display the form.
     */
    public function createAction(Request $request)
    {
        $config = $this->getConfiguration();
        $resource = $this->createNew();

        if ($request->attributes->has('chapter')) {
            $chapter = $this->get('ihadis.repository.chapter')->find($request->attributes->get('chapter'));
            if ($chapter) {
                $resource->setChapter($chapter);
            }
        }

        if ($request->attributes->has('book')) {
            $book = $this->get('ihadis.repository.book')->find($request->attributes->get('book'));
            if ($book) {
                $resource->setBook($book);
            }
        }

        $form = $this->getForm($resource);

        if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
            $event = $this->create($resource);
            if (!$event->isStopped()) {
                $this->setFlash('success', 'create');

                return $this->redirectTo($resource);
            }

            $this->setFlash($event->getMessageType(), $event->getMessage(), $event->getMessageParams());
        }

        if ($config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
            ->view()
            ->setTemplate($config->getTemplate('create.html'))
            ->setData(array(
                $config->getResourceName() => $resource,
                'form'                     => $form->createView()
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * Delete resource.
     */
    public function deleteAction(Request $request)
    {
        $resource = $this->findOr404();

        if ($request->request->get('confirmed', false)) {
            $event = $this->delete($resource);

            if ($request->isXmlHttpRequest()) {
                return JsonResponse::create(array('id' => $request->get('id')));
            }

            if ($event->isStopped()) {
                $this->setFlash($event->getMessageType(), $event->getMessage(), $event->getMessageParams());

                return $this->redirectTo($resource);
            }

            $this->setFlash('success', 'delete');

            $config = $this->getConfiguration();

            return $this->redirectToRoute(
                        $config->getRedirectRoute('index'),
                            $config->getRedirectParameters()
            );
        }

        if ($request->isXmlHttpRequest()) {
            throw new AccessDeniedHttpException;
        }

        $view = $this
            ->view()
            ->setTemplate('IhadisCoreBundle::delete.html.twig')
        ;

        return $this->handleView($view);
    }
}