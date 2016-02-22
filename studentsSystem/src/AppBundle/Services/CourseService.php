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
     */
    public function addCourse($courseData){

        $courseEntity = new Course();
        $courseEntity->setName($courseData['name']);

        $this->courseManager->addCourse($courseEntity);
        $this->courseManager->saveChanges();

        return $courseEntity;

    }

    /**
     * @param $id
     * @return Course|null|object
     */
    public function getCourseById($id){

        $course = $this->courseManager->getCourseById($id);

        if(!$course){
            throw new Exception("No courses found.");
        }
        return $course;
    }

    /**
     * @param Course $course
     * @param $courseData
     * @return Course
     * @throws ValidatorException
     */
    public function updateCourse(Course $course, $courseData){

        if(isset($courseData['name'])){
            $course->setName($courseData['name']);
        }

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

}