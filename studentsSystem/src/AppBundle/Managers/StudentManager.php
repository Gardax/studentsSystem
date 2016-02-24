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

    public function getStudents($start, $end, $filters = [], $getFullInfo, $getCount = false){

        $em = $this->entityManager;

        $parameters = [];

        $queryString = "SELECT ";

        if(!$getCount) {
            $queryString .= "s";
            $queryString .= $getFullInfo ? ", sa, c, spec, sbj" : "";
            $queryString .= " FROM AppBundle:Student s";
        }
        else {
            $queryString .= "count(s.id)
                  FROM AppBundle:Student s";
        }

        if($getFullInfo) {
            $queryString .= " LEFT JOIN s.studentAssessments sa";
            $queryString .= " LEFT JOIN s.course c ";
            $queryString .= " LEFT JOIN s.speciality spec";
            $queryString .= " LEFT JOIN sa.subject sbj";
        }

        $queryString .= " WHERE 1=1 ";

        if(isset($filters['firstName']) && $filters['firstName']) {
            $queryString .= " AND s.firstName LIKE :username";
            $parameters['username'] = $filters['firstName'] . "%";
        }

        if(isset($filters['speciality']) && $filters['speciality']){
            $queryString .= " AND s.studentSpecialityId = :speciality";
            $parameters['speciality'] = $filters['speciality'];
        }

        if(isset($filters['course']) && $filters['course']){
            $queryString .= " AND s.studentCourseId = :course";
            $parameters['course'] = $filters['course'];
        }

        if(isset($filters['email']) && $filters['email']){
            $queryString .= " AND s.email = :email";
            $parameters['email'] = $filters['email'];
        }

        if(isset($filters['facultyNumber']) && $filters['facultyNumber']){
            $queryString .= " AND s.facultyNumber = :facultyNumber";
            $parameters['facultyNumber'] = $filters['facultyNumber'];
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
     * @param $id
     * @return Student|null|object
     */
    public function getStudentById($id)
    {
        $student = $this->entityManager->getRepository("AppBundle:Student")->find($id);

        return $student;
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