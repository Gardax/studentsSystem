<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 11:31 PM
 */

namespace AppBundle\Managers;

use AppBundle\Entity\Course;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseManager
 * @package AppBundle\Managers
 */
class CourseManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em) {
        $this->entityManager=$em;
    }

    /**
     * @param Course $courseEntity
     * @return Course
     */
    public function addCourse(Course $courseEntity) {
        $this->entityManager->persist($courseEntity);
        $this->entityManager->flush();

        return $courseEntity;
    }

    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }
}