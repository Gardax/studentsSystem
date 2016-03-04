<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 11:32 PM
 */

namespace AppBundle\Services;

use AppBundle\Exceptions\ValidatorException;
use AppBundle\Managers\CourseManager;
use AppBundle\Entity\Course;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
/**
 * Class CourseService
 * @package AppBundle\Services
 */
class CourseService
{
    /**
     * @var CourseManager
     */
    protected $courseManager;

    /**
     * @var ValidatorInterface
     */
    protected $validator;


    /**
     * CourseService constructor.
     * @param CourseManager $courseManager
     * @param ValidatorInterface $validator
     */
    public function __construct(CourseManager $courseManager, ValidatorInterface $validator){
        $this->courseManager = $courseManager;
        $this->validator = $validator;
    }

    /**
     * @param $courseData
     * @return Course
     * @throws ValidatorException
     */
    public function addCourse($courseData){

        $courseEntity = new Course();
        $courseEntity->setName($courseData['name']);

        $errors = $this->validator->validate($courseEntity, null, array('add'));

        if(count($errors) > 0){
            throw new ValidatorException($errors);
        }

        $this->courseManager->addCourse($courseEntity);
        $this->courseManager->saveChanges();

        return $courseEntity;

    }

    /**
     * @param $page
     * @param $pageSize
     * @param null $name
     * @param bool $getCount
     * @return array|mixed
     */
    public function getCourses($page, $pageSize, $name = null, $getCount = false){
        $page = ($page < 1) ? 1 : $page;
        $start = ($page -1) *$pageSize;
        $end = $start + $pageSize;

        $courses = $this->courseManager->getCourses($start,$end,$name,$getCount);
        if(!$courses){
            throw new NotFoundHttpException("No courses found.");
        }
        return $courses;

    }

    /**
     * @param $id
     * @return Course|null|object
     */
    public function getCourseById($id){

        $course = $this->courseManager->getCourseById($id);

        return $course;
    }

    /**
     * @param Course $course
     * @param $courseData
     * @return Course
     * @throws ValidatorException
     */
    public function updateCourse(Course $course, $courseData){

        $course->setName($courseData['name']);

        $errors = $this->validator->validate($course, null, array('edit'));

        if(count($errors) > 0){
            throw new ValidatorException($errors);
        }

        $this->courseManager->saveChanges();

        return $course;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteCourseById($id){

        $result = $this->courseManager->deleteCourseById($id);

        return $result;
    }

    /**
     * @param $name
     * @return Course
     */
    public function getCourseName($name){

        $courseName = $this->courseManager->getCourseName($name);

        return $courseName;
    }

}