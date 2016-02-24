<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/24/16
 * Time: 5:09 PM
 */

namespace AppBundle\Managers;

use AppBundle\Entity\StudentAssessment;
use Doctrine\ORM\EntityManager;

/**
 * Class StudentAssessmentManager
 * @package AppBundle\Managers
 */
class StudentAssessmentManager
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
     * @param StudentAssessment $studentAssessmentEntity
     * @return StudentAssessment
     */
    public function addStudentAssessment(StudentAssessment $studentAssessmentEntity) {
        $this->entityManager->persist($studentAssessmentEntity);
        $this->entityManager->flush();

        return $studentAssessmentEntity;
    }

    /**
     * @param $id
     * @return StudentAssessment|null|object
     */
    public function getStudentAssessmentById($id)
    {
        $studentAssessment = $this->entityManager->getRepository("AppBundle:StudentAssessment")->find($id);

        return $studentAssessment;
    }

    /**
     *
     * @param $id
     * @return bool
     */
    public function deleteStudentAssessmentById($id){

        $this->entityManager->remove($id);
        $this->entityManager->flush();

        return true;
    }

    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }
}