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
     * Delete recipe by id.
     *
     * @param $id
     * @return bool
     */
    public function deleteSubjectById($id){
        $this->entityManager->remove($id);
        $this->entityManager->flush();

        return true;
    }

    public function getSubjects($start,$end,$name = null){

        $em = $this->entityManager;

        $parameters = [];

        $queryString = "SELECT s
                  FROM AppBundle:Subject s";

        $queryString .= " WHERE 1=1 ";

        if($name) {
            $queryString .= " AND s.name LIKE :name";
            $parameters['name'] = $name . "%";
        }

        $query = $em->createQuery($queryString)
            ->setParameters($parameters)
            ->setFirstResult($start)
            ->setMaxResults($end);

        $subjects = $query->getResult();

        return $subjects;
    }

    /**
     * @param $id
     * @return Subject|null|object
     */
    public function getSubjectById($id)
    {
        $subject = $this->entityManager->getRepository("AppBundle:Subject")->find($id);

        return $subject;
    }

    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }
}