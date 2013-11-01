<?php

namespace Ihadis\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Hadith
 *
 * @ORM\Table(name="hadiths")
 * @ORM\Entity(repositoryClass="Ihadis\Bundle\CoreBundle\Repository\HadithRepository")
 */
class Hadith
{
    use ORMBehaviors\Translatable\Translatable,
        ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Blameable\Blameable
    ;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="narrator", type="text", nullable=true)
     */
    private $narrator;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="numberPrimary", type="string", length=50, nullable=true)
     */
    private $numberPrimary;

    /**
     * @var string
     *
     * @ORM\Column(name="numberSecondary", type="string", length=50, nullable=true)
     */
    private $numberSecondary;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="text", nullable=true)
     */
    private $reference;

    /**
     * @var boolean
     *
     * @ORM\Column(name="scholarReviewed", type="boolean")
     */
    private $scholarReviewed;

    /**
     * @var integer
     *
     * @ORM\Column(name="validity", type="smallint")
     */
    private $validity;

    /**
     * @var Book
     *
     * @ORM\ManyToOne(targetEntity="Book")
     */
    private $book;

    /**
     * @var Chapter
     *
     * @ORM\ManyToOne(targetEntity="Chapter")
     */
    private $chapter;

    /**
     * @var Section
     *
     * @ORM\ManyToOne(targetEntity="Section")
     */
    private $section;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set narrator
     *
     * @param string $narrator
     * @return Hadith
     */
    public function setNarrator($narrator)
    {
        $this->narrator = $narrator;
    
        return $this;
    }

    /**
     * Get narrator
     *
     * @return string 
     */
    public function getNarrator()
    {
        return $this->narrator;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Hadith
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Hadith
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set numberPrimary
     *
     * @param string $numberPrimary
     * @return Hadith
     */
    public function setNumberPrimary($numberPrimary)
    {
        $this->numberPrimary = $numberPrimary;
    
        return $this;
    }

    /**
     * Get numberPrimary
     *
     * @return string 
     */
    public function getNumberPrimary()
    {
        return $this->numberPrimary;
    }

    /**
     * Set numberSecondary
     *
     * @param string $numberSecondary
     * @return Hadith
     */
    public function setNumberSecondary($numberSecondary)
    {
        $this->numberSecondary = $numberSecondary;
    
        return $this;
    }

    /**
     * Get numberSecondary
     *
     * @return string 
     */
    public function getNumberSecondary()
    {
        return $this->numberSecondary;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Hadith
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    
        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set scholarReviewed
     *
     * @param boolean $scholarReviewed
     * @return Hadith
     */
    public function setScholarReviewed($scholarReviewed)
    {
        $this->scholarReviewed = $scholarReviewed;
    
        return $this;
    }

    /**
     * Get scholarReviewed
     *
     * @return boolean 
     */
    public function getScholarReviewed()
    {
        return $this->scholarReviewed;
    }

    /**
     * Set validity
     *
     * @param integer $validity
     * @return Hadith
     */
    public function setValidity($validity)
    {
        $this->validity = $validity;
    
        return $this;
    }

    /**
     * Get validity
     *
     * @return integer 
     */
    public function getValidity()
    {
        return $this->validity;
    }

    /**
     * Set book
     *
     * @param Book $book
     * @return Chapter
     */
    public function setBook($book)
    {
        $this->book = $book;
        return $this;
    }

    /**
     * Get book
     *
     * @return Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set chapter
     *
     * @param Chapter $chapter
     * @return Section
     */
    public function setChapter($chapter)
    {
        $this->chapter = $chapter;
        return $this;
    }

    /**
     * Get chapter
     *
     * @return Chapter
     */
    public function getChapter()
    {
        return $this->chapter;
    }

    /**
     * Set section
     *
     * @param Section $section
     * @return Hadith
     */
    public function setSection($section)
    {
        $this->section = $section;
        return $this;
    }

    /**
     * Get section
     *
     * @return Section
     */
    public function getSection()
    {
        return $this->section;
    }
}
