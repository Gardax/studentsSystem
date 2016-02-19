<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Students
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Student
{
    /**
     * @ORM\Column(name="student_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="student_course_id", type="integer", nullable=false)
     */
    protected $studentCourseId = '0';

    /**
     * @ORM\Column(name="student_speciality_id", type="integer", nullable=false)
     */
    protected $studentSpecialityId = '0';

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=60, unique=true, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $facultyNumber = '0000000000';

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $educationForm = '';


    /** @ORM\OneToMany(targetEntity="StudentAssessment", mappedBy="student")
     */
    protected $studentAssessments;

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="student")
     */
    protected $courses;

    /**
     * @ORM\OneToMany(targetEntity="Speciality", mappedBy="students")
     */
    protected $specialities;


    public function __construct()
    {
        $this->studentAssessments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->courses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->specialities = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return integer
     */
    public function getStudentCourseId()
    {
        return $this->studentCourseId;
    }

    /**
     * @param integer $studentCourseId
     */
    public function setStudentCourseId($studentCourseId)
    {
        $this->studentCourseId = $studentCourseId;
    }

    /**
     * @return integer
     */
    public function getStudentSpecialityId()
    {
        return $this->studentSpecialityId;
    }

    /**
     * @param integer $studentSpecialityId
     */
    public function setStudentSpecialityId($studentSpecialityId)
    {
        $this->studentSpecialityId = $studentSpecialityId;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFacultyNumber()
    {
        return $this->facultyNumber;
    }

    /**
     * @param string $facultyNumber
     */
    public function setFacultyNumber($facultyNumber)
    {
        $this->facultyNumber = $facultyNumber;
    }

    /**
     * @return string
     */
    public function getEducationForm()
    {
        return $this->educationForm;
    }

    /**
     * @param string $educationForm
     */
    public function setEducationForm($educationForm)
    {
        $this->educationForm = $educationForm;
    }

}
