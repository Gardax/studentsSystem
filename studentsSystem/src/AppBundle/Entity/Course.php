<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Courses
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Course
{
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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


}