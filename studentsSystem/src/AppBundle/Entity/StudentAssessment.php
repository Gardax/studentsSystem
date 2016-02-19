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
    protected $saId;


    /**
     * @var boolean
     *
     * @ORM\Column(name="sa_workload_lectures", type="boolean", nullable=false)
     */
    protected $saWorkloadLectures = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="sa_workload_exercises", type="boolean", nullable=false)
     */
    protected $saWorkloadExercises = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="sa_assessment", type="boolean", nullable=false)
     */
    protected $saAssessment = '0';

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
     * @return integer
     */
    public function getSaId()
    {
        return $this->saId;
    }

    /**
     * @param integer $saId
     */
    public function setSaId($saId)
    {
        $this->saId = $saId;
    }

    /**
     * @return boolean
     */
    public function isSaWorkloadLectures()
    {
        return $this->saWorkloadLectures;
    }

    /**
     * @param boolean $saWorkloadLectures
     */
    public function setSaWorkloadLectures($saWorkloadLectures)
    {
        $this->saWorkloadLectures = $saWorkloadLectures;
    }

    /**
     * @return boolean
     */
    public function isSaWorkloadExercises()
    {
        return $this->saWorkloadExercises;
    }

    /**
     * @param boolean $saWorkloadExercises
     */
    public function setSaWorkloadExercises($saWorkloadExercises)
    {
        $this->saWorkloadExercises = $saWorkloadExercises;
    }

    /**
     * @return boolean
     */
    public function isSaAssessment()
    {
        return $this->saAssessment;
    }

    /**
     * @param boolean $saAssessment
     */
    public function setSaAssessment($saAssessment)
    {
        $this->saAssessment = $saAssessment;
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
