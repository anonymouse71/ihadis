<?php

namespace Ihadis\Bundle\CoreBundle\EventListener;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Ihadis\Bundle\CoreBundle\Entity\Hadith;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TagChangeListener
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

    public function onHadisPreCreate(ResourceEvent $event)
    {
        // Reusing as same functionality so far
        $this->onHadisPreUpdate($event);
    }

    public function onHadisPreUpdate(ResourceEvent $event)
    {
        $entity = $event->getSubject();
        $this->adjustTags($entity);
        //$event->stop('my.message', array('%amount%' => $resource->getAmount()));
    }

    private function adjustTags(Hadith $entity)
    {
        $tagsRaw = $this->container->get('request')->request->get('ihadis_hadith')['tags'];
        $tagger = $this->container->get('ajaxray_tag.tagger');

        $tagger->setCsvTags($entity, $tagsRaw);
    }
}