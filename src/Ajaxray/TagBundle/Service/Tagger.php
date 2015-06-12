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

use Doctrine\Common\Collections\ArrayCollection;
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

    /**
     * Tag an entity with a tagname. Tag will be created if needed.
     *
     *
     * @param $entity
     * @param $tagName
     * @param bool $doFlush
     *
     * @return mixed
     */
    public function tag($entity, $tagName, $doFlush = false)
    {
        $this->throwUnlessTaggable($entity);

        $repo = $this->em->getRepository('AjaxrayTagBundle:Tag');
        $tag = $repo->getByName(trim($tagName));

        if(! $entity->getTags()->contains($tag)) {
            $entity->addTag($tag);
            $tag->increaseFrequency();

            $this->em->persist($tag);

            if($doFlush) {
                $this->em->flush();
            }
        }

        return $entity;
    }

    public function setCsvTags($entity, $csvTags, $doFlush = false)
    {
        $this->throwUnlessTaggable($entity);
        $repo = $this->em->getRepository('AjaxrayTagBundle:Tag');
        $tags = new ArrayCollection();

        foreach(explode(',', $csvTags) as $tagName) {
            if(empty($tagName)) continue;

            $tag = $repo->getByName(trim($tagName));
            $tag->increaseFrequency();

            $tags->add($tag);
            $this->em->persist($tag);
        }

        foreach($entity->getTags() as $oldTag) {
            $oldTag->decreaseFrequency();
        }

        $entity->setTags($tags);

        if($doFlush) {
            $this->em->flush();
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