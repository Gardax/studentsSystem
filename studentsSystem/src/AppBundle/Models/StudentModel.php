<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 10:03 AM
 */

namespace AppBundle\Models;

use AppBundle\Entity\Student;

/**
 * Class StudentModel
 * @package AppBundle\Models
 */
class StudentModel
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $studentCourseId = '0';

    /**
     * @var string
     */
    public $studentSpecialityId = '0';

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $email;


    /**
     * @var string
     */
    public $facultyNumber = '0000000000';

    /**
     * @var string
     */
    public $educationForm = '';

    /**
     * @var integer
     */
    public $studentAssessments;

    /**
     * @var string
     */
    public $courses;

    /**
     * @var string
     */
    public $specialities;

    /**
     * StudentModel constructor.
     * @param Student $student
     */
    public function __construct(Student $student){
        $this->setId($student->getId());
        $this->setStudentCourseId($student->getStudentCourseId());
        $this->setStudentSpecialityId($student->getStudentSpecialityId());
        $this->setFirstName($student->getFirstName());
        $this->setLastName($student->getLastName());
        $this->setEmail($student->getEmail());
        $this->setFacultyNumber($student->getFacultyNumber());
        $this->setEducationForm($student->getEducationForm());
        $this->getStudentAssessments();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getStudentCourseId()
    {
        return $this->studentCourseId;
    }

    /**
     * @param string $studentCourseId
     */
    public function setStudentCourseId($studentCourseId)
    {
        $this->studentCourseId = $studentCourseId;
    }

    /**
     * @return string
     */
    public function getStudentSpecialityId()
    {
        return $this->studentSpecialityId;
    }

    /**
     * @param string $studentSpecialityId
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

    /**
     * @return string
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param string $courses
     */
    public function setCourses($courses)
    {
        $this->courses = $courses;
    }

    /**
     * @return string
     */
    public function getSpecialities()
    {
        return $this->specialities;
    }

    /**
     * @param string $specialities
     */
    public function setSpecialities($specialities)
    {
        $this->specialities = $specialities;
    }

    /**
     * @return int
     */
    public function getStudentAssessments()
    {
        return $this->studentAssessments;
    }

    /**
     * @param int $studentAssessments
     */
    public function setStudentAssessments($studentAssessments)
    {
        $this->studentAssessments = $studentAssessments;
    }



}