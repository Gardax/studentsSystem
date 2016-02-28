<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/24/16
 * Time: 5:08 PM
 */

namespace AppBundle\Controller;

use AppBundle\Exceptions\InvalidFormException;
use AppBundle\Models\StudentAssessmentModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use AppBundle\Services\StudentService;

/**
 * Class StudentAssessmentController
 * @package AppBundle\Controller
 */
class StudentAssessmentController extends Controller
{
    const PAGE_SIZE = 10;
    const SUCCESS = 1;
    const FAIL = 0;

    /**
     * @Route("/add/assessment" , name="addStudentAssessment")
     * @Method({"POST"})
     * @Security("has_role('ROLE_TEACHER')")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addStudentAssessmentAction(Request $request)
    {
        $studentAssessmentService = $this->get('student_assessment_service');
        $studentService = $this->get('student_service');
        $subjectService = $this->get('subject_service');

        $studentEntity= $studentService->getStudentById($request->request->get('studentId'));
        $subjectEntity = $subjectService->getSubjectById($request->request->get('subjectId'));

        $studentAssessmentData = [
            'workloadLectures' => $request->request->get('workloadLectures'),
            'workloadExercises' => $request->request->get('workloadExercises'),
            'assessment' => $request->request->get('assessment'),
        ];

        $studentAssessmentEntity = $studentAssessmentService->addStudentAssessment(
            $studentAssessmentData, $studentEntity, $subjectEntity);

        $studentAssessmentModel = new StudentAssessmentModel($studentAssessmentEntity);

        return new JsonResponse($studentAssessmentModel);
    }
    /**
     * @Route("/assessment/delete/{id}", name="deleteStudentAssessment")
     * @Method("DELETE")
     * @Security("has_role('ROLE_TEACHER')")
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function deleteStudentAssessmentAction(Request $request, $id)
    {
        $studentAssessmentService = $this->get("student_assessment_service");

        $studentAssessmentEntity = $studentAssessmentService->getStudentAssessmentById($id);

        $result = self::FAIL;

        if ($studentAssessmentEntity) {
            $result = $studentAssessmentService->deleteStudentAssessmentById($studentAssessmentEntity);
        }

        $success = $result ? self::SUCCESS : self::FAIL;
        return new JsonResponse(["success" => $success]);
    }

    /**
     * @Route("/assessment/{page}", defaults={"page" = null})]
     * @Method({"GET"})
     * @Security("has_role('ROLE_TEACHER')")
     *
     * @param Request $request
     * @param $page
     * @return JsonResponse
     */
    public function getStudentAssessmentsAction(Request $request, $page)
    {

        $studentAssessmentService = $this->get('student_assessment_service');

        $studentId = $request->query->get('studentId');
        $subjectId = $request->query->get('subjectId');

        $filters = [
            'studentId'  => $request->query->get('studentId'),
            'subjectId' => $request->query->get('subjectId'),

        ];

        $studentAssessmentEntities = $studentAssessmentService->getStudentAssessments(
            $page, self::PAGE_SIZE, $studentId,$subjectId);

        $studentAssessmentModels = array();
        foreach ($studentAssessmentEntities as $studentAssessment) {
            $model = new StudentAssessmentModel($studentAssessment);
            $studentAssessmentModels[] = $model;
        }

        $totalCount = $studentAssessmentService->getStudentAssessments(
            $page, self::PAGE_SIZE, $filters, true);

        $data = [
            'studentAssessments' => $studentAssessmentModels,
            'totalCount' => $totalCount,
            'page' => $page,
            'itemsPerPage' => self::PAGE_SIZE,
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/assessment/edit/{id}", name="updateAssessment")
     * @Method("POST")
     * @Security("has_role('ROLE_TEACHER')")
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws InvalidFormException
     */
    public function updateStudentAssessmentAction(Request $request, $id){

        $studentAssessmentService = $this->get('student_assessment_service');
        $studentService = $this->get('student_service');
        $subjectService = $this->get('subject_service');

        $studentAssessmentData = [
            'workloadLectures' => $request->request->get('workloadLectures'),
            'workloadExercises' => $request->request->get('workloadExercises'),
            'assessment' => $request->request->get('assessment'),
        ];

        $studentId = $request->request->get('studentId');
        $subjectId = $request->request->get('subjectId');

        if(!$studentId){
            throw new BadRequestHttpException('No student id.');
        }
        $studentEntity = $studentService->getStudentById($studentId);

        if(!$subjectId){
            throw new BadRequestHttpException('No student id.');
        }
        $subjectEntity = $subjectService->getSubjectById($subjectId);


        $studentAssessmentEntity = $studentAssessmentService->getStudentAssessmentById($id);

        $studentAssessmentService->updateStudentAssessment(
            $studentAssessmentEntity,$studentEntity,$subjectEntity,$studentAssessmentData);

        $studentAssessmentModel = new StudentAssessmentModel($studentAssessmentEntity);

        return new  JsonResponse($studentAssessmentModel);
    }

    /**
     * @Route("/assessmentId/{id}")]
     * @Method({"GET"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function getUserById(Request $request, $id){

        $studentAssessmentService = $this->get('student_assessment_service');

        $studentAssessmentEntity = $studentAssessmentService->getStudentAssessmentById($id);

        $studentAssessmentModel = new StudentAssessmentModel($studentAssessmentEntity);

        return new JsonResponse($studentAssessmentModel);
    }
}