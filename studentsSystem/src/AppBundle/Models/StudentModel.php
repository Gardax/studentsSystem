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
     * @var
     */
    public $studentAssessments;

    /**
     * @var string
     */
    public $courseName;

    /**
     * @var string
     */
    public $specialityName;

    /**
     * @var string
     */
    public $shortSpecialityName;

    /**
     * StudentModel constructor.
     * @param Student $student
     * @param boolean $buildWithFullInfo
     */
    public function __construct(Student $student, $buildWithFullInfo = false){
        $this->setId($student->getId());
        $this->setFirstName($student->getFirstName());
        $this->setLastName($student->getLastName());
        $this->setEmail($student->getEmail());
        $this->setFacultyNumber($student->getFacultyNumber());
        $this->setEducationForm($student->getEducationForm());
        $this->setCourseName($student->getCourse()->getName());
        $this->setSpecialityName($student->getSpeciality()->getSpecialityLongName());
        $this->setShortSpecialityName($student->getSpeciality()->getSpecialityShortName());

        if($buildWithFullInfo) {
            foreach($student->getStudentAssessments() as $studentAssessment) {
                $this->studentAssessments[$studentAssessment->getSubject()->getId()] = new StudentAssessmentModel($studentAssessment);
            }
        }
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
    public function getShortSpecialityName()
    {
        return $this->shortSpecialityName;
    }

    /**
     * @param string $shortSpecialityName
     */
    public function setShortSpecialityName($shortSpecialityName)
    {
        $this->shortSpecialityName = $shortSpecialityName;
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
    public function getCourseName()
    {
        return $this->courseName;
    }

    /**
     * @param string $courseName
     */
    public function setCourseName($courseName)
    {
        $this->courseName = $courseName;
    }

    /**
     * @return string
     */
    public function getSpecialityName()
    {
        return $this->specialityName;
    }

    /**
     * @param string $specialityName
     */
    public function setSpecialityName($specialityName)
    {
        $this->specialityName = $specialityName;
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