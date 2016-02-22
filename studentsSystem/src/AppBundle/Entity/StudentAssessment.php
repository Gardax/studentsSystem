<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StudentsAssessments
 *
 * @ORM\Table
 * @ORM\Entity
 */
class StudentAssessment
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     *
     * @ORM\Column(type="integer", length=3, nullable=false)
     */
    protected $workloadLectures;

    /**
     *
     * @ORM\Column(type="integer", length=3, nullable=false)
     */
    protected $workloadExercises;

    /**
     *
     * @ORM\Column(type="integer", length=3, nullable=false)
     */
    protected $assessment;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="sa_assessment")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id", nullable=false)
     */
    protected $subject;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="sa_assessment")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="student_id", nullable=false)
     */
    protected $student;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getWorkloadLectures()
    {
        return $this->workloadLectures;
    }

    /**
     * @param mixed $workloadLectures
     */
    public function setWorkloadLectures($workloadLectures)
    {
        $this->workloadLectures = $workloadLectures;
    }

    /**
     * @return mixed
     */
    public function getWorkloadExercises()
    {
        return $this->workloadExercises;
    }

    /**
     * @param mixed $workloadExercises
     */
    public function setWorkloadExercises($workloadExercises)
    {
        $this->workloadExercises = $workloadExercises;
    }

    /**
     * @return mixed
     */
    public function getAssessment()
    {
        return $this->assessment;
    }

    /**
     * @param mixed $assessment
     */
    public function setAssessment($assessment)
    {
        $this->assessment = $assessment;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param mixed $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

}
