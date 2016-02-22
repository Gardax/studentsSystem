<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 11:32 PM
 */

namespace AppBundle\Services;

use AppBundle\Entity\Speciality;
use AppBundle\Managers\SpecialityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SpecialityService
 * @package AppBundle\Services
 */
class SpecialityService
{
    /**
     * @var SpecialityManager
     */
    protected $specialityManager;

    /**
     * SpecialityService constructor.
     * @param SpecialityManager $specialityManager
     */
    public function __construct(SpecialityManager $specialityManager){
        $this->specialityManager = $specialityManager;
    }

    /**
     * @param $specialityData
     * @return Speciality
     */
    public function addSpeciality($specialityData){

        $specialityEntity = new Speciality();
        $specialityEntity->setSpecialityLongName($specialityData['longName']);
        $specialityEntity->setSpecialityShortName($specialityData['shortName']);

        $this->specialityManager->addSpeciality($specialityEntity);
        $this->specialityManager->saveChanges();

        return $specialityEntity;

    }

    /**
     * @param $page
     * @param $pageSize
     * @param array $filters
     * @param bool $getCount
     * @return array|mixed
     */
    public function getSpecialities($page, $pageSize, $filters, $getCount=false){

        $start = ($page -1) *$pageSize;
        $end = $start + $pageSize;

        $specialities = $this->specialityManager->getSpecialities($start, $end, $filters, $getCount);
        if(!$specialities){
            throw new NotFoundHttpException("No specialities found.");
        }
        return $specialities;
    }

    /**
     * @param $id
     * @return Speciality|null|object
     */
    public function getSpecialityById($id){

        $speciality = $this->specialityManager->getSpecialityById($id);

        if(!$speciality){
            throw new Exception("No specialities found.");
        }
        return $speciality;
    }
}