<?php

namespace Ihadis\Bundle\CoreBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ChapterController extends ResourceController
{
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