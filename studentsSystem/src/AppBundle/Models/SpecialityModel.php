<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/20/16
 * Time: 12:06 AM
 */

namespace AppBundle\Models;

use AppBundle\Entity\Speciality;

/**
 * Class SpecialityModel
 * @package AppBundle\Models
 */
class SpecialityModel
{

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $specialityLongName;

    /**
     * @var string
     */
    public $specialityShortName;

    public function __construct(Speciality $speciality){
        $this->setId($speciality->getId());
        $this->setSpecialityLongName($speciality->getSpecialityLongName());
        $this->setSpecialityShortName($speciality->getSpecialityShortName());
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSpecialityLongName()
    {
        return $this->specialityLongName;
    }

    /**
     * @param string $specialityLongName
     */
    public function setSpecialityLongName($specialityLongName)
    {
        $this->specialityLongName = $specialityLongName;
    }

    /**
     * @return string
     */
    public function getSpecialityShortName()
    {
        return $this->specialityShortName;
    }

    /**
     * @param string $specialityShortName
     */
    public function setSpecialityShortName($specialityShortName)
    {
        $this->specialityShortName = $specialityShortName;
    }
}