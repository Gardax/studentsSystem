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
use Symfony\Bridge\Doctrine\Tests\Fixtures\User;

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
            $queryString .= "DISTINCT s";
            $queryString .= " FROM AppBundle:Student s";
        }
        else {
            $queryString .= "count(s.id)
                  FROM AppBundle:Student s";
        }

        $queryString .= " LEFT JOIN s.course c ";
        $queryString .= " LEFT JOIN s.speciality spec";

        if($getFullInfo) {
            $queryString .= " LEFT JOIN s.studentAssessments sa";
            $queryString .= " LEFT JOIN sa.subject sbj";
        }

        $queryString .= " WHERE 1=1 ";

        if(isset($filters['name']) && $filters['name']) {
            $queryString .= " AND CONCAT(CONCAT(s.firstName, ' '), s.lastName) LIKE :name";
            $parameters['name'] = $filters['name'] . "%";
        }

        if(isset($filters['specialityId']) && $filters['specialityId']){
            $queryString .= " AND spec.id = :specialityId";
            $parameters['specialityId'] = $filters['specialityId'];
        }

        if(isset($filters['courseId']) && $filters['courseId']){
            $queryString .= " AND c.id = :courseId";
            $parameters['courseId'] = $filters['courseId'];
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

        //!!!WARNING!!!
        //The array slice is a dirty hack to fix a problem with pagination in doctrine!
        $students = $getCount ? $query->getSingleScalarResult() : array_slice($query->getResult(), 0, $end-$start);

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
     * @param $email
     * @return Student
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getStudentByEmail($email)
    {
        $query = $this->entityManager->createQuery(
            "SELECT s
             FROM AppBundle:Student s
             WHERE s.email = :email"
        )
            ->setParameters([
                "email" => $email
            ]);

        $student = $query->getOneOrNullResult();

        return $student;
    }

    /**
     * @param $facultyNumber
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getStudentByFacultyNumber($facultyNumber)
    {
        $query = $this->entityManager->createQuery(
            "SELECT s
             FROM AppBundle:Student s
             WHERE s.facultyNumber LIKE :facultyNumber"
        )
            ->setParameters([
                "facultyNumber" => $facultyNumber
            ]);

        $student = $query->getOneOrNullResult();

        return $student;
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
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }

    /**
     *
     * @param Student $student
     * @return bool
     */
    public function deleteStudent(Student $student){
        $this->entityManager->remove($student);
        $this->entityManager->flush();

        return true;
    }
}