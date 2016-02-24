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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}