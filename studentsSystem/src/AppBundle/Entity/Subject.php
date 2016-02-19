<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subjects
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Subject
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $workloadLectures = '0';

    /** @ORM\OneToMany(targetEntity="StudentAssessment", mappedBy="subject")
     */
    protected $studentAssessments;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    public $workloadExercises = '0';

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return integer
     */
    public function getWorkloadLectures()
    {
        return $this->workloadLectures;
    }

    /**
     * @param integer $workloadLectures
     */
    public function setWorkloadLectures($workloadLectures)
    {
        $this->workloadLectures = $workloadLectures;
    }

    /**
     * @return int
     */
    public function getWorkloadExercises()
    {
        return $this->workloadExercises;
    }

    /**
     * @param int $workloadExercises
     */
    public function setWorkloadExercises($workloadExercises)
    {
        $this->workloadExercises = $workloadExercises;
    }

}
