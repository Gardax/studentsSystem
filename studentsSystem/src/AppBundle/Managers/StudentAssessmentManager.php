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
     * @param $start
     * @param $end
     * @param array $filters
     * @param bool $getCount
     * @return array|mixed
     */
    public function getStudentAssessments($start, $end, $filters = [], $getCount = false){

        $em = $this->entityManager;

        $parameters = [];

        if(!$getCount) {
            $queryString = "SELECT sa
                  FROM AppBundle:StudentAssessment sa";
        }
        else {
            $queryString = "SELECT count(sa.id)
                  FROM AppBundle:StudentAssessment sa";
        }

        $queryString .= " LEFT JOIN sa.student s LEFT JOIN sa.subject sub  WHERE 1=1 ";

        if(isset($filters['studentId']) && $filters['studentId']) {
            $queryString .= " AND s.id = :studentId";
            $parameters['studentId'] = $filters['studentId'];
        }

        if(isset($filters['subjectId']) && $filters['subjectId']) {
            $queryString .= " AND sub.id = :subjectId";
            $parameters['subjectId'] = $filters['subjectId'];
        }

        if(isset($filters['name']) && $filters['name']) {
            $queryString .= " AND CONCAT(CONCAT(s.firstName, ' '), s.lastName) LIKE :name";
            $parameters['name'] = $filters['name'] . '%';
        }

        $query = $em->createQuery($queryString)
            ->setParameters($parameters);

        if(!$getCount && $end) {
            $query->setFirstResult($start)
                ->setMaxResults($end);
        }

        $studentAssessment = $getCount ? $query->getSingleScalarResult() : $query->getResult();

        return $studentAssessment;
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