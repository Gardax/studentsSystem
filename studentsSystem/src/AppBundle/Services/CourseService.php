<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 11:32 PM
 */

namespace AppBundle\Services;

use AppBundle\Entity\Course;
use AppBundle\Managers\CourseManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * CourseService constructor.
     * @param CourseManager $courseManager
     */
    public function __construct(CourseManager $courseManager){
        $this->courseManager = $courseManager;
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
}