<?php

namespace Ihadis\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $lastName;

    /**
     * var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Chapter")
     */
    protected $chapters;

    public function __construct()
    {
        parent::__construct();

        $this->chapters = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set chapters
     *
     * @param mixed $chapters
     * @return User
     */
    public function setChapters($chapters)
    {
        $this->chapters = $chapters;
        return $this;
    }

    /**
     * Get chapters
     *
     * @return ArrayCollection
     */
    public function getChapters()
    {
        return $this->chapters;
    }

    /**
     * Add new chapter
     *
     * @param Chapter $chapter
     * @return User
     */
    public function addChapter(Chapter $chapter)
    {
        $this->chapters[] = $chapter;
        return $this;
    }

    /**
     * Set firstName
     *
     * @param mixed $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Get firstName
     *
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param mixed $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Get lastName
     *
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}