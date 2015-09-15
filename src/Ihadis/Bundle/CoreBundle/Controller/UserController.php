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

use Ihadis\Bundle\CoreBundle\Entity\User;
use Ihadis\Bundle\CoreBundle\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as CommonController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * User Controller
 *
 * @author Mohammad Emran Hasan <phpfour@gmail.com>
 */
class UserController extends CommonController
{
    public function indexAction()
    {
        $this->goHomeUnlessLoggedIn();

        $query = $this->get('doctrine.orm.entity_manager')->getRepository('IhadisCoreBundle:User')
            ->createQueryBuilder('u')
            ->getQuery();

        return $this->render('IhadisCoreBundle:User:index.html.twig', array(
            'users' => $query->getResult()
        ));
    }

    public function newAction()
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);

        return $this->render('IhadisCoreBundle:User:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    public function createAction(Request $request)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $form = $this->createForm(new UserType(), $user);
        $em = $this->getDoctrine()->getManager();

        if ($form->submit($request)) {

            $emailExists = $em->getRepository('IhadisCoreBundle:User')->findOneBy(array(
                'email' => $user->getEmail()
            ));

            $usernameExists = $em->getRepository('IhadisCoreBundle:User')->findOneBy(array(
                'username' => $user->getUsername()
            ));

            if (!$emailExists && !$usernameExists) {

                $encoder     = $this->container->get('security.encoder_factory')->getEncoder($user);
                $newPassword = $encoder->encodePassword($user->getPassword(), $user->getSalt());

                $user->setPassword($newPassword);
                $user->setEnabled(true);

                $em->persist($user);
                $em->flush();

                return $this->redirect($this->generateUrl('ihadis_admin_user_index'));

            } else {

                if ($emailExists) {
                    $this->get('session')->getFlashBag()->add('error', 'Sorry, this email address already exists.');
                }

                if ($usernameExists) {
                    $this->get('session')->getFlashBag()->add('error', 'Sorry, this username already exists.');
                }

                return $this->render('IhadisCoreBundle:User:new.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView(),

                ));

            }
        }

        return $this->render('IhadisCoreBundle:User:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    public function removeAction(User $user)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            throw new AccessDeniedException();
        }

        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            $this->addFlash('success','User have successfully removed!');
        } catch (\Exception $e) {
            $this->addFlash('error','Error in removing User! Please try later.');
        }

        return $this->redirect($this->generateUrl('ihadis_admin_user_index'));
    }

    public function chaptersAction(User $user)
    {
        $chapters = array();
        $chapterIds = array();
        $selectedChapters = array();

        $em = $this->get('doctrine.orm.entity_manager');
        $books = $em->getRepository('IhadisCoreBundle:Book')->findAll();

        if ($this->getRequest()->request->has('book')) {
            
            $chapters = $em->getRepository('IhadisCoreBundle:Chapter')
                ->findBy(array('book' => $this->getRequest()->request->get('book')));

        }
        
        if ($this->getRequest()->request->has('chapters')) {

            $newChapterIds = $this->getRequest()->request->get('chapters');
            $assignedChapters = array();

            foreach ($newChapterIds as $chapterId) {
                $assignedChapters[] = $em->getRepository('IhadisCoreBundle:Chapter')->find($chapterId);
            }

            $user->setChapters($assignedChapters);
            $em->persist($user);
            $em->flush();

        } 

        foreach ($user->getChapters() as $chapter) {
            $selectedChapters[] = $chapter->getId();
        }

        return $this->render('IhadisCoreBundle:User:chapters.html.twig', array(
            'books' => $books,
            'chapters' => $chapters,
            'selectedChapters' => $selectedChapters
        ));
    }

    protected function addFlash($type, $message)
    {
        $this->get('session')->getFlashBag()->add($type,$message);
    }

    private function goHomeUnlessLoggedIn()
    {
        if(! $this->getUser()) {
            return $this->redirect($this->generateUrl('ihadis_homepage'));
        }
    }
} 