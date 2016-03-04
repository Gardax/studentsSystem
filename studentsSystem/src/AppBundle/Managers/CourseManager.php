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
     *
     * @param Course $course
     * @return bool
     */
    public function deleteCourse(Course $course){
        $this->entityManager->remove($course);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @param $id
     * @return Course|null|object
     */
    public function getCourseById($id) {
        $course = $this->entityManager->getRepository("AppBundle:Course")->find($id);

        return $course;
    }

    /**
     * @param $start
     * @param $end
     * @param null $name
     * @param bool $getCount
     * @return array|mixed
     */
    public function getCourses($start, $end, $name = null, $getCount = false){
        $em = $this->entityManager;

        $parameters = [];

        if(!$getCount) {
            $queryString = "SELECT c
                  FROM AppBundle:Course c";
        }
        else {
            $queryString = "SELECT count(c.id)
                  FROM AppBundle:Course c";
        }

        $queryString .= " WHERE 1=1 ";

        if($name) {
            $queryString .= " AND c.name LIKE :name";
            $parameters['name'] = $name . "%";
        }

        $query = $em->createQuery($queryString)
            ->setParameters($parameters);

        if(!$getCount && $end) {
            $query->setFirstResult($start)
                ->setMaxResults($end);
        }

        $courses = $getCount ? $query->getSingleScalarResult() : $query->getResult();
        return $courses;
    }

    /**
     * @param string $name
     * @return Course
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCourseByName($name)
    {
        $query = $this->entityManager->createQuery(
            "SELECT co
             FROM AppBundle:Course co
             WHERE co.name = :name"
        )
            ->setParameters([
                "name" => $name
            ]);

        $course = $query->getOneOrNullResult();

        return $course;
    }

    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }
}