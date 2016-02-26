<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Specialities
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Speciality
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"edit"}, message="The long name cannot be blank.")
     */
    protected $specialityLongName;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Assert\NotBlank(groups={"edit"}, message="Short name cannot be blank.")
     */
    protected $specialityShortName;

    public function __construct()
    {
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSpecialityLongName()
    {
        return $this->specialityLongName;
    }

    /**
     * @param string $specialityLongName
     */
    public function setSpecialityLongName($specialityLongName)
    {
        $this->specialityLongName = $specialityLongName;
    }

    /**
     * @return string
     */
    public function getSpecialityShortName()
    {
        return $this->specialityShortName;
    }

    /**
     * @param string $specialityShortName
     */
    public function setSpecialityShortName($specialityShortName)
    {
        $this->specialityShortName = $specialityShortName;
    }

}
