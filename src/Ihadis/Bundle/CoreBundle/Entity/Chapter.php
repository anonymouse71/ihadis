<?php

namespace Ihadis\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Chapter
 *
 * @ORM\Table(name="chapters")
 * @ORM\Entity(repositoryClass="Ihadis\Bundle\CoreBundle\Repository\ChapterRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Chapter
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="hadis_range", type="string", length=20, nullable=true)
     */
    private $range;

    /**
     * @var string
     *
     * @ORM\Column(name="preface", type="text", nullable=true)
     */
    private $preface;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number = 0;

    /**
     * @var Book
     *
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="chapters")
     */
    private $book;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Section", mappedBy="chapter")
     */
    private $sections;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Chapter
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
     * @return Chapter
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
     * Set number
     *
     * @param int $number
     * @return Chapter
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * Get number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get total section count
     *
     * @return int
     */
    public function getSectionCount()
    {
        return $this->sections->count();
    }

    /**
     * @return ArrayCollection
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Get total hadith count
     *
     * @return int
     */
    public function getHadithCount()
    {
        $total = 0;

        foreach ($this->sections as $section) {
            $total += $section->getHadithCount();
        }

        return $total;
    }

    public function getHadithNumberRange()
    {
        $first = 0;
        $last = 0;

        foreach ($this->sections as $section) {

            $hadiths = $section->getHadiths();

            if ($hadiths->count() > 0) {
                if ($first == 0) {
                    $first = $hadiths->first()->getNumberPrimary();
                } else {
                    $last = $hadiths->last()->getNumberPrimary();
                }
            }

        }

        return $first . ' - ' . $last;
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
     * @return string
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @param string $range
     */
    public function setRange($range)
    {
        $this->range = $range;
    }
}
