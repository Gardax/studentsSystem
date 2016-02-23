<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 9:51 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use AppBundle\Exceptions\InvalidFormException;
use AppBundle\Models\StudentModel;
use AppBundle\Entity\Course;
use AppBundle\Entity\Speciality;
use AppBundle\Models\SubjectModel;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use AppBundle\Services\StudentService;

/**
 * Class StudentController
 * @package AppBundle\Controller
 */
class StudentController extends Controller
{
    const PAGE_SIZE = 5;

    /**
     * @Route("/student/{page}", defaults={"page" = 1})]
     * @Method({"GET"})
     * @param Request $request
     * @param $page
     * @return JsonResponse
     */
    public function getStudentsAction(Request $request, $page){

        $service = $this->get('student_service');

        $filters = [
            'username'  => $request->query->get('username'),
            'speciality' => $request->query->get('speciality'),
            'course' => $request->query->get('course'),
            'email' => $request->query->get('email'),
            'facultyNumber' => $request->query->get('facultyNumber')
        ];

        $getFullInfo = (bool)$request->query->get('getFullInfo');

        $studentEntities = $service->getStudents($page, self::PAGE_SIZE, $filters, $getFullInfo);

        $studentModels = array();
        foreach ($studentEntities as $student) {
            $model = new StudentModel($student, $getFullInfo);
            $studentModels[] = $model;
        }

        $totalCount = $service->getStudents($page, self::PAGE_SIZE, $filters, false, true);


        $data = [
            'students' => $studentModels,
            'totalCount' => $totalCount,
            'page' => $page
        ];

        if($getFullInfo) {
            $subjects = [];
            foreach ($studentEntities[0]->getStudentAssessments() as $studentAssessment) {
                $subjects[] = new SubjectModel($studentAssessment->getSubject());
            }

            $data['subjects'] = $subjects;
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/add/student" , name="addStudent")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addStudentAction(Request $request)
    {
        $studentService = $this->get('student_service');
        $courseService = $this->get('course_service');
        $specialityService = $this->get('speciality_service');

        //TODO: Before you add the student you should first check if the email is free.

        //TODO: Check if the IDs are passed.
        $courseEntity = $courseService->getCourseById($request->request->get('courseId'));
        $specialityEntity = $specialityService->getSpecialityById($request->request->get('specialityId'));

        $studentData = [
            'firstName' => $request->request->get('firstName'),
            'lastName' => $request->request->get('lastName'),
            'email' => $request->request->get('email'),
            'facultyNumber' => $request->request->get('facultyNumber'),
            'educationForm' => $request->request->get('educationForm'),
        ];

        $studentEntity = $studentService->addStudent($studentData, $courseEntity, $specialityEntity);
        $studentModel = new StudentModel($studentEntity);

        return new JsonResponse($studentModel);
    }
}