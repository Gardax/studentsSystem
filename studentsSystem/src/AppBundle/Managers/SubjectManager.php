<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/20/16
 * Time: 8:05 PM
 */

namespace AppBundle\Managers;

use AppBundle\Entity\Subject;
use Doctrine\ORM\EntityManager;

/**
 * Class SubjectManager
 * @package AppBundle\Managers
 */
class SubjectManager
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
     * @param Subject $subjectEntity
     * @return Subject
     */
    public function addSubject(Subject $subjectEntity) {
        $this->entityManager->persist($subjectEntity);
        $this->entityManager->flush();

        return $subjectEntity;
    }

    /**
     *
     * @param $id
     * @return bool
     */
    public function deleteSubjectById($id){
        $this->entityManager->remove($id);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @return \AppBundle\Entity\Subject[]|array
     */
    public function getAllSubjects(){

        $subjects = $this->entityManager->getRepository('AppBundle:Subject')->findAll();

        return $subjects;
    }

    /**
     * @param $start
     * @param $end
     * @param null $name
     * @param bool $getCount
     * @return array|mixed
     */
    public function getSubjects($start,$end,$name = null,$getCount=false){

        $em = $this->entityManager;

        $parameters = [];

        if(!$getCount) {
            $queryString = "SELECT s
                  FROM AppBundle:Subject s";
        }
        else {
            $queryString = "SELECT count(s.id)
                  FROM AppBundle:Subject s";
        }

        $queryString .= " WHERE 1=1 ";

        if($name) {
            $queryString .= " AND s.name LIKE :name";
            $parameters['name'] = $name . "%";
        }

        $query = $em->createQuery($queryString)
            ->setParameters($parameters);

        if(!$getCount && $end) {
            $query->setFirstResult($start)
                ->setMaxResults($end);
        }

        $subjects = $getCount ? $query->getSingleScalarResult() : $query->getResult();
        return $subjects;
    }

    /**
     * @param int $id
     * @return Subject|null
     */
    public function getSubjectById($id)
    {
        $subject = $this->entityManager->getRepository("AppBundle:Subject")->find($id);

        return $subject;
    }

    /**
     * @param array $ids
     * @return Subject[]
     */
    public function getSubjectsByIds($ids) {
        $query = "SELECT s FROM AppBundle:Subject s WHERE s.id IN (:subjectIds)";

        $query = $this->entityManager->createQuery($query)
            ->setParameter('subjectIds', $ids);

        return $query->getResult();
    }

    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }
}