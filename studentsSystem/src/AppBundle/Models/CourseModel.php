<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 11:54 PM
 */

namespace AppBundle\Models;

use AppBundle\Entity\Course;

/**
 * Class CourseModel
 * @package AppBundle\Models
 */
class CourseModel
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * CourseModel constructor.
     * @param Course $course
     */
    public function __construct(Course $course){
        $this->setId($course->getId());
        $this->setName($course->getName());
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }



}