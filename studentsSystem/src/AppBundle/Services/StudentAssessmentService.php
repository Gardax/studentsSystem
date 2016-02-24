<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/24/16
 * Time: 5:08 PM
 */

namespace AppBundle\Services;

use AppBundle\Exceptions\ValidatorException;
use AppBundle\Entity\Student;
use AppBundle\Entity\Subject;
use AppBundle\Managers\StudentAssessmentManager;
use AppBundle\Entity\StudentAssessment;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class StudentAssessmentService
 * @package AppBundle\Services
 */
class StudentAssessmentService
{
    /**
     * @var StudentAssessmentManager
     */
    protected $studentAssessmentManager;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * StudentAssessmentService constructor.
     * @param StudentAssessmentManager $studentAssessmentManager
     * @param ValidatorInterface $validator
     */
    public function __construct(StudentAssessmentManager $studentAssessmentManager, ValidatorInterface $validator){
        $this->validator=$validator;
        $this->studentAssessmentManager = $studentAssessmentManager;
    }

    /**
     * @param $page
     * @param $pageSize
     * @param $studentId
     * @param $subjectId
     * @param bool $getCount
     * @return array|mixed
     */
    public function getStudentAssessments($page, $pageSize, $studentId, $subjectId, $getCount = false ){

        $start = ($page -1) *$pageSize;
        $end = $start + $pageSize;

        $studentAssessments = $this->studentAssessmentManager->getStudentAssessments(
            $start, $end, $studentId, $subjectId, $getCount);

        if(!$studentAssessments){
            throw new NotFoundHttpException("No student assessments found.");
        }
        return $studentAssessments;
    }

    /**
     * @param $id
     * @return StudentAssessment|null|object
     */
    public function getStudentAssessmentById($id){

        $studentAssessment = $this->studentAssessmentManager->getStudentAssessmentById($id);

        if(!$studentAssessment){
            throw new BadRequestHttpException("There are no student assessment with this id.");
        }
        return $studentAssessment;
    }

    /**
     * @param $studentAssessmentData
     * @param Student $studentEntity
     * @param Subject $subjectEntity
     * @return StudentAssessment
     */
    public function addStudentAssessment($studentAssessmentData, Student $studentEntity, Subject $subjectEntity){

        $studentAssessmentEntity = new StudentAssessment();
        $studentAssessmentEntity->setStudent($studentEntity);
        $studentAssessmentEntity->setSubject($subjectEntity);
        $studentAssessmentEntity->setWorkloadLectures($studentAssessmentData['workloadLectures']);
        $studentAssessmentEntity->setWorkloadExercises($studentAssessmentData['workloadExercises']);
        $studentAssessmentEntity->setAssessment($studentAssessmentData['assessment']);

        $this->studentAssessmentManager->addStudentAssessment($studentAssessmentEntity);
        $this->studentAssessmentManager->saveChanges();

        return $studentAssessmentEntity;

    }

    /**
     * @param StudentAssessment $studentAssessment
     * @param Student $student
     * @param Subject $subject
     * @param $studentAssessmentData
     * @return StudentAssessment
     * @throws ValidatorException
     */
    public function updateStudentAssessment(
        StudentAssessment $studentAssessment,Student $student, Subject $subject, $studentAssessmentData){

        $studentAssessment->setStudent($student);
        $studentAssessment->setSubject($subject);
        $studentAssessment->setWorkloadLectures($studentAssessmentData['workloadLectures']);
        $studentAssessment->setWorkloadExercises($studentAssessmentData['workloadExercises']);
        $studentAssessment->setAssessment($studentAssessmentData['assessment']);

        $errors = $this->validator->validate($studentAssessment, null, array('edit'));

        if(count($errors) > 0){
            throw new ValidatorException($errors);
        }

        $this->studentAssessmentManager->saveChanges();

        return $studentAssessment;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteStudentAssessmentById($id){

        $result = $this->studentAssessmentManager->deleteStudentAssessmentById($id);

        return $result;
    }
}