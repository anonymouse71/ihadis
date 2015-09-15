<?php

namespace Ihadis\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Validity
 *
 * @ORM\Table(name="validities")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Validity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort_order", type="smallint", nullable=true)
     */
    private $sortOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=20, nullable=true)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="background", type="string", length=20, nullable=true)
     */
    private $background;

    /**
     * @var Validity
     *
     * @ORM\ManyToOne(targetEntity="Validity", inversedBy="subTypes")
     */
    private $superType;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Validity", mappedBy="superType")
     */
    private $subTypes;

    public function __construct()
    {
        $this->subTypes = new ArrayCollection();
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        if(empty($this->color) && $parent = $this->getSuperType()) {
            return $parent->getColor();
        }

        return $this->color;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Validity
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param int $id
     *
     * @return Validity
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get subTypes
     *
     * @return ArrayCollection
     */
    public function getSubTypes()
    {
        return $this->subTypes;
    }

    /**
     * Set subTypes
     *
     * @param ArrayCollection $subTypes
     *
     * @return Validity
     */
    public function setSubTypes($subTypes)
    {
        $this->subTypes = $subTypes;
        return $this;
    }

    /**
     * Add subType
     *
     * @param Validity
     *
     * @return Validity
     */
    public function addSubType(Validity $subType)
    {
        $this->subTypes->add($subType);
        return $this;
    }

    /**
     * Get superType
     *
     * @return Validity
     */
    public function getSuperType()
    {
        return $this->superType;
    }

    /**
     * Set superType
     *
     * @param Validity $superType
     *
     * @return Validity
     */
    public function setSuperType(Validity $superType)
    {
        $this->superType = $superType;

        if(empty($this->sortOrder) && $parent = $this->getSuperType()) {
            $this->setSortOrder($parent->getSortOrder() + 1);
        }

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Validity
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get background
     *
     * @return string
     */
    public function getBackground()
    {
        if(empty($this->background) && $parent = $this->getSuperType()) {
            return $parent->getBackground();
        }

        return $this->background;
    }

    /**
     * Set background
     *
     * @param string $background
     *
     * @return Validity
     */
    public function setBackground($background)
    {
        $this->background = $background;
        return $this;
    }

    /**
     * Get sortOrder
     *
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * Set sortOrder
     *
     * @param int $sortOrder
     *
     * @return Validity
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }
}
