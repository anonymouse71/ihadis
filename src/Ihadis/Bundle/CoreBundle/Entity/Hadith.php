<?php

namespace Ihadis\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Hadith
 *
 * @ORM\Table(name="hadiths")
 * @ORM\Entity(repositoryClass="Ihadis\Bundle\CoreBundle\Repository\HadithRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Hadith
{
    use ORMBehaviors\Translatable\Translatable,
        ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Blameable\Blameable
    ;

    const VALIDITY_NONE  = 0;
    const VALIDITY_MAUDU = 10;
    const VALIDITY_DAIF  = 20;
    const VALIDITY_HASAN = 30;
    const VALIDITY_SAHIH = 40;

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
     * @var string
     *
     * @ORM\Column(name="explanation", type="text", nullable=true)
     */
    private $explanation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="scholarReviewed", type="boolean")
     */
    private $scholarReviewed;

    /**
     * @var boolean
     *
     * @ORM\Column(name="crossChecked", type="boolean")
     */
    private $crossChecked;

    /**
     * @var integer
     *
     * @ORM\Column(name="validity", type="smallint")
     */
    private $validity;

    /**
     * @var Book
     *
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="hadiths")
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
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="hadiths")
     */
    private $section;

    /**
     * @ORM\PreFlush
     */
    public function handleTranslation()
    {
        $this->mergeNewTranslations();
    }

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
     * Set explanation
     *
     * @param string $explanation
     * @return Hadith
     */
    public function setExplanation($explanation)
    {
        $this->explanation = $explanation;
        return $this;
    }

    /**
     * Get explanation
     *
     * @return string
     */
    public function getExplanation()
    {
        return $this->explanation;
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
     * Set crossChecked
     *
     * @param boolean $crossChecked
     * @return Hadith
     */
    public function setCrossChecked($crossChecked)
    {
        $this->crossChecked = $crossChecked;
        return $this;
    }

    /**
     * Get crossChecked
     *
     * @return boolean
     */
    public function getCrossChecked()
    {
        return $this->crossChecked;
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

    /**
     * Get Narrator in English
     *
     * @return mixed
     */
    public function getNarratorEnglish()
    {
        return $this->translate('en')->getNarrator();
    }

    /**
     * Set Narrator in English
     *
     * @param $narrator
     *
     * @return mixed
     */
    public function setNarratorEnglish($narrator)
    {
        $this->translate('en')->setNarrator($narrator);
        return $this;
    }

    /**
     * Get Narrator in Arabic
     *
     * @return mixed
     */
    public function getNarratorArabic()
    {
        return $this->translate('ar')->getNarrator();
    }

    /**
     * Set Narrator in Arabic
     *
     * @param $narrator
     *
     * @return mixed
     */
    public function setNarratorArabic($narrator)
    {
        $this->translate('ar')->setNarrator($narrator);
        return $this;
    }

    /**
     * Get Body in English
     *
     * @return mixed
     */
    public function getBodyEnglish()
    {
        return $this->translate('en')->getBody();
    }

    /**
     * Set Body in English
     *
     * @param $body
     *
     * @return mixed
     */
    public function setBodyEnglish($body)
    {
        $this->translate('en')->setBody($body);
        return $this;
    }

    /**
     * Get Body in Arabic
     *
     * @return mixed
     */
    public function getBodyArabic()
    {
        return $this->translate('ar')->getBody();
    }

    /**
     * Set Body in Arabic
     *
     * @param $body
     *
     * @return mixed
     */
    public function setBodyArabic($body)
    {
        $this->translate('ar')->setBody($body);
        return $this;
    }

    /**
     * Get Reference in English
     *
     * @return mixed
     */
    public function getReferenceEnglish()
    {
        return $this->translate('en')->getReference();
    }

    /**
     * Set Reference in English
     *
     * @param $reference
     *
     * @return mixed
     */
    public function setReferenceEnglish($reference)
    {
        $this->translate('en')->setReference($reference);
        return $this;
    }

    /**
     * Get Reference in Arabic
     *
     * @return mixed
     */
    public function getReferenceArabic()
    {
        return $this->translate('ar')->getReference();
    }

    /**
     * Set Reference in Arabic
     *
     * @param $reference
     *
     * @return mixed
     */
    public function setReferenceArabic($reference)
    {
        $this->translate('ar')->setReference($reference);
        return $this;
    }

    public function getAuthenticityLabel()
    {
        switch ($this->validity) {
            case self::VALIDITY_NONE    : return '-';
            case self::VALIDITY_SAHIH   : return 'Sahih';
            case self::VALIDITY_HASAN   : return 'Hasan';
            case self::VALIDITY_MAUDU   : return 'Maudu';
            case self::VALIDITY_DAIF    : return "D'aif";
        }
    }

    public function getReferencePartsEnglish($index = 0)
    {
        $lines = explode("\n", $this->getReferenceEnglish());
        return isset($lines[$index-1]) ? $lines[$index-1] : '';
    }
}
