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
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }

}