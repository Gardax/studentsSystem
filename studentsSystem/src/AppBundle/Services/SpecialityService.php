<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 11:32 PM
 */

namespace AppBundle\Services;

use AppBundle\Exceptions\ValidatorException;
use AppBundle\Entity\Speciality;
use AppBundle\Managers\SpecialityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;


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
     * @var ValidatorInterface
     */
    protected $validator;


    /**
     * SpecialityService constructor.
     * @param SpecialityManager $specialityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(SpecialityManager $specialityManager, ValidatorInterface $validator){
        $this->specialityManager = $specialityManager;
        $this->validator = $validator;
    }

    /**
     * @param $specialityData
     * @return Speciality
     * @throws ValidatorException
     */
    public function addSpeciality($specialityData){

        $specialityEntity = new Speciality();
        $specialityEntity->setSpecialityLongName($specialityData['longName']);
        $specialityEntity->setSpecialityShortName($specialityData['shortName']);

        $errors = $this->validator->validate($specialityEntity, null, array('add'));

        if(count($errors) > 0) {
            throw new ValidatorException($errors);
        }

        $this->specialityManager->addSpeciality($specialityEntity);
        $this->specialityManager->saveChanges();

        return $specialityEntity;
    }

    /**
     * @param Speciality $speciality
     * @param $specialityData
     * @return Speciality
     * @throws ValidatorException
     */
    public function updateSpeciality(Speciality $speciality, $specialityData){

        $speciality->setSpecialityLongName($specialityData['longName']);
        $speciality->setSpecialityShortName($specialityData['shortName']);

        $errors = $this->validator->validate($speciality, null, array('edit'));

        if(count($errors) > 0){
            throw new ValidatorException($errors);
        }

        $this->specialityManager->saveChanges();

        return $speciality;
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
            throw new BadRequestHttpException("No specialities found.");
        }
        return $specialities;
    }

    /**
     * @param $id
     * @return Speciality|null|object
     */
    public function getSpecialityById($id){

        $speciality = $this->specialityManager->getSpecialityById($id);

        return $speciality;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteSpecialityById($id){

        $result = $this->specialityManager->deleteSpecialityById($id);

        return $result;
    }
}