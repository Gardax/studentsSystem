<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    protected $specialityLongName;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    protected $specialityShortName;

    /**
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="student_id")
     */
    protected $student;

    public function __construct()
    {
        $this->student = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param mixed $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSpecialityLongName()
    {
        return $this->specialityLongName;
    }

    /**
     * @param mixed $specialityLongName
     */
    public function setSpecialityLongName($specialityLongName)
    {
        $this->specialityLongName = $specialityLongName;
    }

    /**
     * @return mixed
     */
    public function getSpecialityShortName()
    {
        return $this->specialityShortName;
    }

    /**
     * @param mixed $specialityShortName
     */
    public function setSpecialityShortName($specialityShortName)
    {
        $this->specialityShortName = $specialityShortName;
    }

}
