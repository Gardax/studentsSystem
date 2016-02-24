<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/20/16
 * Time: 8:04 PM
 */
namespace AppBundle\Services;

use AppBundle\Exceptions\ValidatorException;
use AppBundle\Managers\SubjectManager;
use AppBundle\Entity\Subject;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class SubjectService
 * @package AppBundle\Services
 */
class SubjectService
{
    /**
     * @var SubjectManager
     */
    protected $subjectManager;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * SubjectService constructor.
     * @param SubjectManager $subjectManager
     * @param ValidatorInterface $validator
     */
    public function __construct(SubjectManager $subjectManager, ValidatorInterface $validator){
        $this->validator=$validator;
        $this->subjectManager=$subjectManager;
    }

    /**
     * @param $id
     * @return Subject|null|object
     */
    public function getSubjectById($id){

        $subject = $this->subjectManager->getSubjectById($id);

        if(!$subject){
            throw new BadRequestHttpException("No subject found.");
        }
        return $subject;
    }

    /**
     * @return \AppBundle\Entity\Subject[]|array
     */
    public function getAllSubjects(){

        $subjects = $this->subjectManager->getAllSubjects();

        return $subjects;
    }

    /**
     * @param $page
     * @param $pageSize
     * @param null $name
     * @param bool $getCount
     * @return array|mixed
     */
    public function getSubjects($page,$pageSize,$name = null,$getCount=false){

        $start = ($page -1) *$pageSize;
        $end = $start + $pageSize;

        $subjects = $this->subjectManager->getSubjects($start,$end,$name,$getCount);
        if(!$subjects){
            throw new NotFoundHttpException("No subjects found.");
        }
        return $subjects;

    }

    /**
     * @param $subjectData
     * @return Subject
     */
    public function addSubject($subjectData){

        $subjectEntity = new Subject();
        $subjectEntity->setName($subjectData['name']);
        $subjectEntity->setWorkloadLectures($subjectData['workloadLectures']);
        $subjectEntity->setWorkloadExercises($subjectData['workloadExercises']);

        $this->subjectManager->addSubject($subjectEntity);
        $this->subjectManager->saveChanges();

        return $subjectEntity;

    }

    /**
     * @param Subject $subject
     * @param $subjectData
     * @return Subject
     * @throws ValidatorException
     */
    public function updateSubject(Subject $subject, $subjectData){

        if(isset($subjectData['name'])){
            $subject->setName($subjectData['name']);
        }

        if(isset($subjectData['workloadLectures'])){
            $subject->setWorkloadLectures($subjectData['workloadLectures']);
        }

        if(isset($subjectData['workloadExercises'])){
            $subject->setWorkloadExercises($subjectData['workloadExercises']);
        }

        $errors = $this->validator->validate($subject, null, array('edit'));

        if(count($errors) > 0){
            throw new ValidatorException($errors);
        }

        $this->subjectManager->saveChanges();

        return $subject;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteSubjectById($id){

        $result = $this->subjectManager->deleteSubjectById($id);
        return $result;
    }
}