<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", length=45, nullable=false)
     *
     * @Assert\NotBlank(message="First name cannot be blank.")
     * @Assert\Length(
     *     min=3,
     *     max=45,
     *     minMessage="Last name should be between 3 and 45 characters.",
     *     maxMessage="Last name should be between 3 and 45 characters."
     * )
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=45, nullable=false)
     *
     * @Assert\NotBlank(message="Last name cannot be blank.")
     * @Assert\Length(
     *     min=3,
     *     max=45,
     *     minMessage="Last name should be between 3 and 45 characters.",
     *     maxMessage="Last name should be between 3 and 45 characters."
     * )
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
     * @ORM\ManyToOne(targetEntity="Course")
     */
    protected $course;

    /**
     * @ORM\ManyToOne(targetEntity="Speciality")
     */
    protected $speciality;


    public function __construct()
    {
        $this->studentAssessments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param Course $course
     */
    public function setCourse(Course $course)
    {
        $this->course = $course;
    }

    /**
     * @return Speciality
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * @param Speciality $speciality
     */
    public function setSpeciality(Speciality $speciality)
    {
        $this->speciality = $speciality;
    }

    /**
     * @return StudentAssessment[]
     */
    public function getStudentAssessments()
    {
        return $this->studentAssessments;
    }

    /**
     * @param StudentAssessment[] $studentAssessments
     */
    public function setStudentAssessments($studentAssessments)
    {
        $this->studentAssessments = $studentAssessments;
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
