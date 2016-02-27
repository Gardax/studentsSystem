<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 10:30 AM
 */

namespace AppBundle\Services;

use AppBundle\Entity\Speciality;
use AppBundle\Managers\StudentManager;
use AppBundle\Entity\Student;
use AppBundle\Entity\Course;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class StudentService
 * @package AppBundle\Services
 */
class StudentService
{
    /**
     * @var StudentManager
     */
    protected $studentManager;

    /**
     * StudentService constructor.
     * @param StudentManager $studentManager
     */
    public function __construct(StudentManager $studentManager){
        $this->studentManager=$studentManager;
    }

    /**
     * @param $page
     * @param $pageSize
     * @param $filters
     * @param $getFullInfo
     * @param bool $getCount
     * @return Student[]
     */
    public function getStudents($page, $pageSize, $filters, $getFullInfo, $getCount=false ){

        $start = ((int)$page - 1) * $pageSize;
        $end = $start + $pageSize;

        $students = $this->studentManager->getStudents($start, $end, $filters, $getFullInfo, $getCount);
        if(!$students){
            throw new NotFoundHttpException("No students found.");
        }
        return $students;
    }

    /**
     * @param $id
     * @return Student|null|object
     */
    public function getStudentById($id){

        $student = $this->studentManager->getStudentById($id);

        if(!$student){
            throw new BadRequestHttpException("No student found.");
        }
        return $student;
    }

    /**
     * @param $studentData
     * @param Course $courseEntity
     * @param Speciality $specialityEntity
     * @return Student
     */
    public function addStudent($studentData, Course $courseEntity, Speciality $specialityEntity){

        $studentEntity = new Student();
        $studentEntity->setCourse($courseEntity);
        $studentEntity->setSpeciality($specialityEntity);
        $studentEntity->setFirstName($studentData['firstName']);
        $studentEntity->setLastName($studentData['lastName']);
        $studentEntity->setEmail($studentData['email']);
        $studentEntity->setFacultyNumber($studentData['facultyNumber']);
        $studentEntity->setEducationForm($studentData['educationForm']);

        $this->studentManager->addStudent($studentEntity);
        $this->studentManager->saveChanges();

        return $studentEntity;

    }
}