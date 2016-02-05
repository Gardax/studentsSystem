<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specialities
 *
 * @ORM\Table(name="specialities", uniqueConstraints={@ORM\UniqueConstraint(name="speciality_name_long_UNIQUE", columns={"speciality_name_long"}), @ORM\UniqueConstraint(name="speciality_name_short_UNIQUE", columns={"speciality_name_short"})})
 * @ORM\Entity
 */
class Specialities
{
    /**
     * @var string
     *
     * @ORM\Column(name="speciality_name_long", type="string", length=255, nullable=true)
     */
    private $specialityNameLong;

    /**
     * @var string
     *
     * @ORM\Column(name="speciality_name_short", type="string", length=16, nullable=true)
     */
    private $specialityNameShort;

    /**
     * @var integer
     *
     * @ORM\Column(name="speciality_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $specialityId;



    /**
     * Set specialityNameLong
     *
     * @param string $specialityNameLong
     *
     * @return Specialities
     */
    public function setSpecialityNameLong($specialityNameLong)
    {
        $this->specialityNameLong = $specialityNameLong;

        return $this;
    }

    /**
     * Get specialityNameLong
     *
     * @return string
     */
    public function getSpecialityNameLong()
    {
        return $this->specialityNameLong;
    }

    /**
     * Set specialityNameShort
     *
     * @param string $specialityNameShort
     *
     * @return Specialities
     */
    public function setSpecialityNameShort($specialityNameShort)
    {
        $this->specialityNameShort = $specialityNameShort;

        return $this;
    }

    /**
     * Get specialityNameShort
     *
     * @return string
     */
    public function getSpecialityNameShort()
    {
        return $this->specialityNameShort;
    }

    /**
     * Get specialityId
     *
     * @return integer
     */
    public function getSpecialityId()
    {
        return $this->specialityId;
    }
}
