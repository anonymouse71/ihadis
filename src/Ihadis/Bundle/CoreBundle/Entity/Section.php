<?php

namespace Ihadis\Bundle\CoreBundle\Entity;

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
}
