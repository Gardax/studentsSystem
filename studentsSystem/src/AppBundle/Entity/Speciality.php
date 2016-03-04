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
     * @Assert\NotBlank(groups={"edit","add"}, message="The long name cannot be blank.")
     */
    protected $specialityLongName;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Assert\NotBlank(groups={"edit","add"}, message="Short name cannot be blank.")
     */
    protected $specialityShortName;

    /**
     * @var @ORM\OneToMany(targetEntity="Student", mappedBy="speciality", cascade={"remove"})
     */
    protected $students;

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

    /**
     * @return Student[]
     */
    public function getStudents()
    {
        return $this->students;
    }
}
