<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/20/16
 * Time: 8:05 PM
 */

namespace AppBundle\Models;

use AppBundle\Entity\Subject;

/**
 * Class SubjectModel
 * @package AppBundle\Models
 */
class SubjectModel
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $workloadLectures = '0';

    /**
     * @var int
     */
    public $workloadExercises = '0';

    /**
     * SubjectModel constructor.
     * @param Subject $subject
     */
    public function __construct(Subject $subject){
        $this->setId($subject->getId());
        $this->setName($subject->getName());
        $this->setWorkloadLectures($subject->getWorkloadLectures());
        $this->setWorkloadExercises($subject->getWorkloadExercises());
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

    /**
     * @return int
     */
    public function getWorkloadLectures()
    {
        return $this->workloadLectures;
    }

    /**
     * @param int $workloadLectures
     */
    public function setWorkloadLectures($workloadLectures)
    {
        $this->workloadLectures = $workloadLectures;
    }

    /**
     * @return int
     */
    public function getWorkloadExercises()
    {
        return $this->workloadExercises;
    }

    /**
     * @param int $workloadExercises
     */
    public function setWorkloadExercises($workloadExercises)
    {
        $this->workloadExercises = $workloadExercises;
    }


}