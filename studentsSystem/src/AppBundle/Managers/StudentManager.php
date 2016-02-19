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

    public function getStudents($start,$end,$firstName = null,$speciality = null,$course = null){

        $em = $this->entityManager;

        $parameters = [];

        $queryString = "SELECT s
                  FROM AppBundle:Student s";

        $queryString .= " WHERE 1=1 ";

        if($firstName) {
            $queryString .= " AND s.firstName LIKE :username";
            $parameters['username'] = "%" . $firstName . "%";
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
            ->setParameters($parameters)
            ->setFirstResult($start)
            ->setMaxResults($end);

        $students = $query->getResult();
        return $students;
    }

    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }
}