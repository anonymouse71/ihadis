<?php

namespace Ihadis\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Book
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="Ihadis\Bundle\CoreBundle\Repository\BookRepository")
 */
class Book
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="synopsis", type="text", nullable=true)
     */
    private $synopsis;

    /**
     * @var string
     *
     * @ORM\Column(name="publication", type="string", length=255, nullable=true)
     */
    private $publication;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publishDate", type="date", nullable=true)
     */
    private $publishDate;

    /**
     * @var string
     *
     * @ORM\Column(name="coverPhoto", type="string", length=255, nullable=true)
     */
    private $coverPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="edition", type="string", length=50, nullable=true)
     */
    private $edition;

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean", nullable=true)
     */
    private $published;

    /**
     * @var integer
     *
     * @ORM\Column(name="numberOfChapters", type="integer")
     */
    private $numberOfChapters = 0;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Chapter", mappedBy="book")
     */
    private $chapters;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Section", mappedBy="book", fetch="EXTRA_LAZY")
     */
    private $sections;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Hadith", mappedBy="book", fetch="EXTRA_LAZY")
     */
    private $hadiths;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=50)
     */
    private $slug;

    public function __construct()
    {
        $this->chapters = new ArrayCollection();
        $this->sections = new ArrayCollection();
        $this->hadiths  = new ArrayCollection();
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
     * @return Book
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
     * Set description
     *
     * @param string $description
     * @return Book
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set publication
     *
     * @param string $publication
     * @return Book
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
        return $this;
    }

    /**
     * Get publication
     *
     * @return string 
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * Set coverPhoto
     *
     * @param string $coverPhoto
     * @return Book
     */
    public function setCoverPhoto($coverPhoto)
    {
        $this->coverPhoto = $coverPhoto;
        return $this;
    }

    /**
     * Get coverPhoto
     *
     * @return string 
     */
    public function getCoverPhoto()
    {
        return $this->coverPhoto;
    }

    /**
     * Set publishDate
     *
     * @param \DateTime $publishDate
     * @return Book
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;
        return $this;
    }

    /**
     * Get publishDate
     *
     * @return \DateTime 
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set edition
     *
     * @param string $edition
     * @return Book
     */
    public function setEdition($edition)
    {
        $this->edition = $edition;
        return $this;
    }

    /**
     * Get edition
     *
     * @return string 
     */
    public function getEdition()
    {
        return $this->edition;
    }

    /**
     * Set synopsis
     *
     * @param string $synopsis
     * @return Book
     */
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;
        return $this;
    }

    /**
     * Get synopsis
     *
     * @return string 
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Book
     */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set numberOfChapters
     *
     * @param integer $numberOfChapters
     * @return Book
     */
    public function setNumberOfChapters($numberOfChapters)
    {
        $this->numberOfChapters = $numberOfChapters;
        return $this;
    }

    /**
     * Get numberOfChapters
     *
     * @return integer 
     */
    public function getNumberOfChapters()
    {
        return $this->numberOfChapters;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Book
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get chapters
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getChapters()
    {
        return $this->chapters;
    }

    /**
     * Get hadiths
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getHadiths()
    {
        return $this->hadiths;
    }

    /**
     * Get sections
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSections()
    {
        return $this->sections;
    }

    public function getChapterCount()
    {
        return $this->chapters->count();
    }

    public function getSectionCount()
    {
        return $this->sections->count();
    }

    public function getHadithCount()
    {
        return $this->hadiths->count();
    }
}