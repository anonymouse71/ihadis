<?php

namespace Ihadis\Bundle\CoreBundle\EventListener;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Ihadis\Bundle\CoreBundle\Entity\Hadith;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class DoctrineListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $entity;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->entityManager = $args->getEntityManager();

//        if ($entity instanceof Hadith) {
//            $this->adjustTags($entity);
//        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {

    }

    public function postUpdate(LifecycleEventArgs $args)
    {

    }

    public function postPersist(LifecycleEventArgs $args)
    {

    }
}