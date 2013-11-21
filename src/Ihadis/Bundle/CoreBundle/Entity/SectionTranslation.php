<?php

namespace Ihadis\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * @ORM\Table(name="section_translation")
 */
class SectionTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=50)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=3000)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="preface", type="text", nullable=true)
     */
    private $preface;

    /**
     * Set number
     *
     * @param string $number
     * @return Section
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Section
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * Set preface
     *
     * @param string $preface
     * @return Section
     */
    public function setPreface($preface)
    {
        $this->preface = $preface;
        return $this;
    }

    /**
     * Get preface
     *
     * @return string
     */
    public function getPreface()
    {
        return $this->preface;
    }
}