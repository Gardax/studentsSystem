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
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
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
     * @param $id
     * @return StudentAssessment|null|object
     */
    public function getStudentAssessmentById($id){

        $studentAssessment = $this->studentAssessmentManager->getStudentAssessmentById($id);

        if(!$studentAssessment){
            throw new Exception("There are no student assessments.");
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
     * @param $id
     * @return bool
     */
    public function deleteStudentAssessmentById($id){

        $result = $this->studentAssessmentManager->deleteStudentAssessmentById($id);

        return $result;
    }
}