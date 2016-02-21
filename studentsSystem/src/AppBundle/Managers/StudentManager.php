<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 10:28 AM
 */

namespace AppBundle\Managers;

use AppBundle\Entity\Student;
use Doctrine\ORM\EntityManager;

/**
 * Class StudentManager
 * @package AppBundle\Managers
 */
class StudentManager
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

    public function getStudents($start, $end, $firstName = null,$speciality = null,$course = null, $getCount=false){

        $em = $this->entityManager;

        $parameters = [];

        $queryString = "";

        if(!$getCount) {
            $queryString = "SELECT s
                  FROM AppBundle:Student s";
        }
        else {
            $queryString = "SELECT count(s.id)
                  FROM AppBundle:Student s";
        }

        $queryString .= " WHERE 1=1 ";

        if($firstName) {
            $queryString .= " AND s.firstName LIKE :username";
            $parameters['username'] = $firstName . "%";
        }

        if($speciality){
            $queryString .= " AND s.studentSpecialityId = :speciality";
            $parameters['speciality'] = $speciality;
        }

        if($course){
            $queryString .= " AND s.studentCourseId = :course";
            $parameters['course'] = $course;
        }

        $query = $em->createQuery($queryString)
            ->setParameters($parameters);

        if(!$getCount) {
            $query->setFirstResult($start)
                ->setMaxResults($end);
        }

        $students = $getCount ? $query->getSingleScalarResult() : $query->getResult();
        return $students;
    }

    /**
     * @param Student $studentEntity
     * @return Student
     */
    public function addStudent(Student $studentEntity) {
        $this->entityManager->persist($studentEntity);
        $this->entityManager->flush();

        return $studentEntity;
    }

    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }
}