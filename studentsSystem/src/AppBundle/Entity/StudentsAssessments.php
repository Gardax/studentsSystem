<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StudentsAssessments
 *
 * @ORM\Table(name="students_assessments", uniqueConstraints={@ORM\UniqueConstraint(name="sa_student_subject_UNIQUE", columns={"sa_student_id", "sa_subject_id"})}, indexes={@ORM\Index(name="sa_student_id", columns={"sa_student_id"}), @ORM\Index(name="sa_subject_id", columns={"sa_subject_id"})})
 * @ORM\Entity
 */
class StudentsAssessments
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sa_student_id", type="integer", nullable=false)
     */
    private $saStudentId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="sa_subject_id", type="integer", nullable=false)
     */
    private $saSubjectId = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="sa_workload_lectures", type="boolean", nullable=false)
     */
    private $saWorkloadLectures = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="sa_workload_exercises", type="boolean", nullable=false)
     */
    private $saWorkloadExercises = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="sa_assesment", type="boolean", nullable=false)
     */
    private $saAssesment = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="sa_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $saId;



    /**
     * Set saStudentId
     *
     * @param integer $saStudentId
     *
     * @return StudentsAssessments
     */
    public function setSaStudentId($saStudentId)
    {
        $this->saStudentId = $saStudentId;

        return $this;
    }

    /**
     * Get saStudentId
     *
     * @return integer
     */
    public function getSaStudentId()
    {
        return $this->saStudentId;
    }

    /**
     * Set saSubjectId
     *
     * @param integer $saSubjectId
     *
     * @return StudentsAssessments
     */
    public function setSaSubjectId($saSubjectId)
    {
        $this->saSubjectId = $saSubjectId;

        return $this;
    }

    /**
     * Get saSubjectId
     *
     * @return integer
     */
    public function getSaSubjectId()
    {
        return $this->saSubjectId;
    }

    /**
     * Set saWorkloadLectures
     *
     * @param boolean $saWorkloadLectures
     *
     * @return StudentsAssessments
     */
    public function setSaWorkloadLectures($saWorkloadLectures)
    {
        $this->saWorkloadLectures = $saWorkloadLectures;

        return $this;
    }

    /**
     * Get saWorkloadLectures
     *
     * @return boolean
     */
    public function getSaWorkloadLectures()
    {
        return $this->saWorkloadLectures;
    }

    /**
     * Set saWorkloadExercises
     *
     * @param boolean $saWorkloadExercises
     *
     * @return StudentsAssessments
     */
    public function setSaWorkloadExercises($saWorkloadExercises)
    {
        $this->saWorkloadExercises = $saWorkloadExercises;

        return $this;
    }

    /**
     * Get saWorkloadExercises
     *
     * @return boolean
     */
    public function getSaWorkloadExercises()
    {
        return $this->saWorkloadExercises;
    }

    /**
     * Set saAssesment
     *
     * @param boolean $saAssesment
     *
     * @return StudentsAssessments
     */
    public function setSaAssesment($saAssesment)
    {
        $this->saAssesment = $saAssesment;

        return $this;
    }

    /**
     * Get saAssesment
     *
     * @return boolean
     */
    public function getSaAssesment()
    {
        return $this->saAssesment;
    }

    /**
     * Get saId
     *
     * @return integer
     */
    public function getSaId()
    {
        return $this->saId;
    }
}
