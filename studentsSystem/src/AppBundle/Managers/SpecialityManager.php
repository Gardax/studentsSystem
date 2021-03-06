<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 11:32 PM
 */

namespace AppBundle\Managers;

use AppBundle\Entity\Speciality;
use Doctrine\ORM\EntityManager;

/**
 * Class SpecialityManager
 * @package AppBundle\Managers
 */
class SpecialityManager
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
    public function getSpecialities($start, $end, $filters = [], $getCount = false){

        $em = $this->entityManager;

        $parameters = [];

        if(!$getCount) {
            $queryString = "SELECT s
                  FROM AppBundle:Speciality s";
        }
        else {
            $queryString = "SELECT count(s.id)
                  FROM AppBundle:Speciality s";
        }

        $queryString .= " WHERE 1=1 ";

        if(isset($filters['longName']) && $filters['longName']) {
            $queryString .= " AND s.specialityLongName LIKE :longName";
            $parameters['longName'] = $filters['longName'] . "%";
        }

        if(isset($filters['shortName']) && $filters['shortName']) {
            $queryString .= " AND s.specialityShortName = :shortName";
            $parameters['shortName'] = $filters['shortName'];
        }

        $query = $em->createQuery($queryString)
            ->setParameters($parameters);

        if(!$getCount && $end) {
            $query->setFirstResult($start)
                ->setMaxResults($end);
        }

        $specialities = $getCount ? $query->getSingleScalarResult() : $query->getResult();
        return $specialities;
    }

    /**
     * @param Speciality $specialityEntity
     * @return Speciality
     */
    public function addSpeciality(Speciality $specialityEntity) {
        $this->entityManager->persist($specialityEntity);
        $this->entityManager->flush();

        return $specialityEntity;
    }

    /**
     * @param $id
     * @return Speciality|null|object
     */
    public function getSpecialityById($id)
    {
        $speciality = $this->entityManager->getRepository("AppBundle:Speciality")->find($id);

        return $speciality;
    }

    /**
     *
     * @param $id
     * @return bool
     */
    public function deleteSpecialityById($id){

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