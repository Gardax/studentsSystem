<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 10:30 AM
 */

namespace AppBundle\Services;

use AppBundle\Managers\StudentManager;
use AppBundle\Entity\Student;
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
     * @param null $firstName
     * @param null $speciality
     * @param null $course
     * @return array
     */
    public function getStudents($page,$pageSize,$firstName = null,$speciality = null,$course = null, $getCount=false){

        $start = ($page -1) *$pageSize;
        $end = $start + $pageSize;

        $students = $this->studentManager->getStudents($start,$end,$firstName, $speciality, $course, $getCount);
        if(!$students){
            throw new NotFoundHttpException("No students found.");
        }
        return $students;
    }

    /**
     * @param $studentData
     * @return Student
     */
    public function addStudent($studentData){

        $studentEntity = new Student();
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