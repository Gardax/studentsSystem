<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subjects
 *
 * @ORM\Table(name="subjects", uniqueConstraints={@ORM\UniqueConstraint(name="subject_name_UNIQUE", columns={"subject_name"})})
 * @ORM\Entity
 */
class Subjects
{
    /**
     * @var string
     *
     * @ORM\Column(name="subject_name", type="string", length=45, nullable=true)
     */
    private $subjectName;

    /**
     * @var integer
     *
     * @ORM\Column(name="subject_workload_lectures", type="smallint", nullable=false)
     */
    private $subjectWorkloadLectures = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="subject_workload_exercises", type="smallint", nullable=false)
     */
    private $subjectWorkloadExercises = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="subject_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $subjectId;



    /**
     * Set subjectName
     *
     * @param string $subjectName
     *
     * @return Subjects
     */
    public function setSubjectName($subjectName)
    {
        $this->subjectName = $subjectName;

        return $this;
    }

    /**
     * Get subjectName
     *
     * @return string
     */
    public function getSubjectName()
    {
        return $this->subjectName;
    }

    /**
     * Set subjectWorkloadLectures
     *
     * @param integer $subjectWorkloadLectures
     *
     * @return Subjects
     */
    public function setSubjectWorkloadLectures($subjectWorkloadLectures)
    {
        $this->subjectWorkloadLectures = $subjectWorkloadLectures;

        return $this;
    }

    /**
     * Get subjectWorkloadLectures
     *
     * @return integer
     */
    public function getSubjectWorkloadLectures()
    {
        return $this->subjectWorkloadLectures;
    }

    /**
     * Set subjectWorkloadExercises
     *
     * @param integer $subjectWorkloadExercises
     *
     * @return Subjects
     */
    public function setSubjectWorkloadExercises($subjectWorkloadExercises)
    {
        $this->subjectWorkloadExercises = $subjectWorkloadExercises;

        return $this;
    }

    /**
     * Get subjectWorkloadExercises
     *
     * @return integer
     */
    public function getSubjectWorkloadExercises()
    {
        return $this->subjectWorkloadExercises;
    }

    /**
     * Get subjectId
     *
     * @return integer
     */
    public function getSubjectId()
    {
        return $this->subjectId;
    }
}
