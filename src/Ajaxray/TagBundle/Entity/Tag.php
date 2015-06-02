<?php
namespace Ajaxray\TagBundle\Entity;
/*
 * This file is part of the Symfony2 Bundle Ajaxray/TagBundle.
 *
 * (c) Anis Uddin Ahmad <anisniit@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Doctrine\ORM\Mapping as ORM;


/**
 * Tag
 *
 * @author Anis Uddin Ahmad <anisniit@gmail.com>
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity(repositoryClass="Ajaxray\TagBundle\Entity\Repository\TagRepository")
 */
class Tag 
{
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $frequency = 0;

    function __construct($name = null)
    {
        if($name) {
            $this->name = $name;
        }

        return $this;
    }

    function __toString()
    {
        return $this->getName();
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
     * @return Tag
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get frequency
     *
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set frequency
     *
     * @param int $frequency
     *
     * @return Tag
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
        return $this;
    }
    
} 