<?php

namespace Ihadis\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Section
 *
 * @ORM\Table(name="sections")
 * @ORM\Entity(repositoryClass="Ihadis\Bundle\CoreBundle\Repository\SectionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Section
{
    use ORMBehaviors\Translatable\Translatable,
        ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Blameable\Blameable
    ;

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
     * @var Book
     *
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="sections")
     */
    private $book;

    /**
     * @var Chapter
     *
     * @ORM\ManyToOne(targetEntity="Chapter", inversedBy="sections")
     */
    private $chapter;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Hadith", mappedBy="section")
     */
    private $hadiths;

    public function __construct()
    {
        $this->hadiths = new ArrayCollection();
    }

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
     * Get Hadiths
     *
     * @return ArrayCollection
     */
    public function getHadiths()
    {
        return $this->hadiths;
    }

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

    public function getHadithCount()
    {
        return $this->hadiths->count();
    }

    /**
     * Get Title in English
     *
     * @return mixed
     */
    public function getTitleEnglish()
    {
        return $this->translate('en')->getTitle();
    }

    /**
     * Set Title in English
     *
     * @param $title
     *
     * @return mixed
     */
    public function setTitleEnglish($title)
    {
        $this->translate('en')->setTitle($title);
        return $this;
    }

    /**
     * Get Title in Arabic
     *
     * @return mixed
     */
    public function getTitleArabic()
    {
        return $this->translate('ar')->getTitle();
    }

    /**
     * Set Title in Arabic
     *
     * @param $title
     *
     * @return mixed
     */
    public function setTitleArabic($title)
    {
        $this->translate('ar')->setTitle($title);
    }

    /**
     * Get Preface in English
     *
     * @return mixed
     */
    public function getPrefaceEnglish()
    {
        return $this->translate('en')->getPreface();
    }

    /**
     * Set Preface in English
     *
     * @param $preface
     *
     * @return mixed
     */
    public function setPrefaceEnglish($preface)
    {
        $this->translate('en')->setPreface($preface);
        return $this;
    }

    /**
     * Get Preface in Arabic
     *
     * @return mixed
     */
    public function getPrefaceArabic()
    {
        return $this->translate('ar')->getPreface();
    }

    /**
     * Set Preface in Arabic
     *
     * @param $preface
     *
     * @return mixed
     */
    public function setPrefaceArabic($preface)
    {
        $this->translate('ar')->setPreface($preface);
    }

    /**
     * Get Number in English
     *
     * @return mixed
     */
    public function getNumberEnglish()
    {
        return $this->translate('en')->getNumber();
    }

    /**
     * Set Number in English
     *
     * @param $number
     *
     * @return mixed
     */
    public function setNumberEnglish($number)
    {
        $this->translate('en')->setNumber($number);
        return $this;
    }

    /**
     * Get Number in Arabic
     *
     * @return mixed
     */
    public function getNumberArabic()
    {
        return $this->translate('ar')->getNumber();
    }

    /**
     * Set Number in Arabic
     *
     * @param $number
     *
     * @return mixed
     */
    public function setNumberArabic($number)
    {
        $this->translate('ar')->setNumber($number);
    }
}
