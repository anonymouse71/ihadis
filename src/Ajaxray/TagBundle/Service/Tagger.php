<?php
/*
 * This file is part of the ihadis project.
 *
 * (c) Anis Uddin Ahmad <anisniit@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ajaxray\TagBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Tagger
 *
 * Small description about Tagger.
 *
 * @author Anis Uddin Ahmad <anisniit@gmail.com>
 */
class Tagger 
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $em;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->em        = $container->get('doctrine.orm.entity_manager');

        return $this;
    }

    public function tag($entity, $tagName, $doFlush = false)
    {
        $this->throwUnlessTaggable($entity);

        $repo = $this->em->getRepository('AjaxrayTagBundle:Tag');
        $tag = $repo->getByName($tagName);

        if(! $entity->getTags()->contains($tag)) {
            $entity->addTag($tag);
            $tag->setFrequency($tag->getFrequency() + 1);

            $this->em->persist($tag);
            $this->em->persist($entity);

            if($doFlush) {
                $this->em->flush();
            }
        }

        return $entity;
    }

    private function throwUnlessTaggable($obj)
    {
        if(! in_array('Ajaxray\TagBundle\Traits\Taggable', class_uses($obj))) {
            $msg  = get_class($obj) .' is not using Trait "Ajaxray\TagBundle\Traits\Taggable". ';
            $msg .= 'ajaxray_tag.tagger service can tag only entities that are using this Trait.';

            throw new \InvalidArgumentException($msg);
        }
    }
}