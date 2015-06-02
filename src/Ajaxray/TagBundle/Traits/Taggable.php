<?php
/*
 * This file is part of the ihadis project.
 *
 * (c) Anis Uddin Ahmad <anisniit@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Ajaxray\TagBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Ajaxray\TagBundle\Entity\Tag;

trait Taggable 
{
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Ajaxray\TagBundle\Entity\Tag", cascade={"persist"} )
     * @ORM\JoinTable(name="tags_items",
     *      joinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     **/
    private $tags;

    protected function prepareTags()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * Get tags
     *
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set tags
     *
     * @param mixed $tags
     *
     * @return mixed
     */
    public function setTags(ArrayCollection $tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * Add tags
     *
     * @param Tag $tag
     *
     * @return mixed
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * Remove tag
     *
     * @param Tag $tag
     *
     * @return mixed
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
        return $this;
    }
}