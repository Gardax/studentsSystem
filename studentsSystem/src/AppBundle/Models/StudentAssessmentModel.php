<?php
/**
 * Created by PhpStorm.
 * User: gardax
 * Date: 2/23/16
 * Time: 9:44 PM
 */

namespace AppBundle\Models;


use AppBundle\Entity\StudentAssessment;

class StudentAssessmentModel
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $lectureAttended;

    /**
     * @var integer
     */
    public $exerciseAttended;

    /**
     * @var integer
     */
    public $lectureTotal;

    /**
     * @var integer
     */
    public $exerciseTotal;

    /**
     * @var integer
     */
    public $assessment;

    /**
     * @var string
     */
    public $studentFirstName;

    /**
     * @var string
     */
    public $studentLastName;

    /**
     * @var string
     */
    public $subjectName;

    public function __construct(StudentAssessment $studentAssessment) {
        $this->setId($studentAssessment->getId());
        $this->setExerciseAttended($studentAssessment->getWorkloadExercises());
        $this->setLectureAttended($studentAssessment->getWorkloadLectures());
        $this->setAssessment($studentAssessment->getAssessment());
        $this->setExerciseTotal($studentAssessment->getSubject()->getWorkloadExercises());
        $this->setLectureTotal($studentAssessment->getSubject()->getWorkloadLectures());
        $this->setStudentFirstName($studentAssessment->getStudent()->getFirstName());
        $this->setStudentLastName($studentAssessment->getStudent()->getLastName());
        $this->setSubjectName($studentAssessment->getSubject()->getName());
    }

    /**
     * @return string
     */
    public function getStudentLastName()
    {
        return $this->studentLastName;
    }

    /**
     * @param string $studentLastName
     */
    public function setStudentLastName($studentLastName)
    {
        $this->studentLastName = $studentLastName;
    }

    /**
     * @return string
     */
    public function getSubjectName()
    {
        return $this->subjectName;
    }

    /**
     * @param string $subjectName
     */
    public function setSubjectName($subjectName)
    {
        $this->subjectName = $subjectName;
    }

    /**
     * @return string
     */
    public function getStudentFirstName()
    {
        return $this->studentFirstName;
    }

    /**
     * @param string $studentFirstName
     */
    public function setStudentFirstName($studentFirstName)
    {
        $this->studentFirstName = $studentFirstName;
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
     * @return int
     */
    public function getLectureAttended()
    {
        return $this->lectureAttended;
    }

    /**
     * @param int $lectureAttended
     */
    public function setLectureAttended($lectureAttended)
    {
        $this->lectureAttended = $lectureAttended;
    }

    /**
     * @return int
     */
    public function getExerciseAttended()
    {
        return $this->exerciseAttended;
    }

    /**
     * @param int $exerciseAttended
     */
    public function setExerciseAttended($exerciseAttended)
    {
        $this->exerciseAttended = $exerciseAttended;
    }

    /**
     * @return int
     */
    public function getLectureTotal()
    {
        return $this->lectureTotal;
    }

    /**
     * @param int $lectureTotal
     */
    public function setLectureTotal($lectureTotal)
    {
        $this->lectureTotal = $lectureTotal;
    }

    /**
     * @return int
     */
    public function getExerciseTotal()
    {
        return $this->exerciseTotal;
    }

    /**
     * @param int $exerciseTotal
     */
    public function setExerciseTotal($exerciseTotal)
    {
        $this->exerciseTotal = $exerciseTotal;
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

}