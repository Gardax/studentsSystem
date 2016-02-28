<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="integer", length=3, nullable=false)
     * @Assert\NotBlank(groups={"edit","add"}, message="Lectures cannot be blank.")
     */
    protected $workloadLectures;

    /**
     * @ORM\Column(type="integer", length=3, nullable=false)
     * @Assert\NotBlank(groups={"edit","add"}, message="Exercises cannot be blank.")
     */
    protected $workloadExercises;

    /**
     * @ORM\Column(type="integer", length=3, nullable=false)
     * @Assert\NotBlank(groups={"edit","add"}, message="Assessment cannot be blank.")
     */
    protected $assessment;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="studentAssessments")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id", nullable=false)
     */
    protected $subject;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="studentAssessments")
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
     * @return Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param Subject $subject
     */
    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param Student $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

}
