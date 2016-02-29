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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
            'page' => $page,
            'itemsPerPage' => self::PAGE_SIZE
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
     * @Security("has_role('ROLE_TEACHER')")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addStudentAction(Request $request)
    {
        $studentService = $this->get('student_service');
        $courseService = $this->get('course_service');
        $specialityService = $this->get('speciality_service');

        $studentData = [
            'firstName' => $request->request->get('firstName'),
            'lastName' => $request->request->get('lastName'),
            'email' => $request->request->get('email'),
            'facultyNumber' => $request->request->get('facultyNumber'),
            'educationForm' => $request->request->get('educationForm'),
        ];

        $courseId = $request->request->get('courseId');
        $specialityId = $request->request->get('specialityId');
        $facultyNumber = $request->request->get('facultyNumber');
        $email = $request->request->get('email');

        $courseEntity = $courseService->getCourseById($request->request->get('courseId'));
        $specialityEntity = $specialityService->getSpecialityById($request->request->get('specialityId'));

        $studentEmail = $studentService->getStudentByEmail($request->request->get('email'));
        $studentFacultyNumber = $studentService->getStudentByFacultyNumber($request->request->get('facultyNumber'));

        if(!$courseEntity){
            if(!$courseId){
                throw new BadRequestHttpException("You must add course.");
            }
            throw new BadRequestHttpException("There is no course with this id.");
        }

        if(!$specialityEntity){
            if(!$specialityId){
                throw new BadRequestHttpException("You must add speciality.");
            }
            throw new BadRequestHttpException("There is no speciality with this id.");
        }

        if($studentEmail){
            if(!$email){
                throw new BadRequestHttpException("You must add email.");
            }
            throw new BadRequestHttpException("The email already exists.");
        }

        if($studentFacultyNumber){
            if(!$facultyNumber){
                throw new BadRequestHttpException("You must add a faculty number.");
            }
            throw new BadRequestHttpException("This faculty number already exists.");
        }

        $studentEntity = $studentService->addStudent($studentData, $courseEntity, $specialityEntity);

        $studentModel = new StudentModel($studentEntity);

        return new JsonResponse($studentModel);
    }

    /**
     * @Route("/student/edit/{id}", name="updateStudent")
     * @Method("PUT")
     * @Security("has_role('ROLE_TEACHER')")
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws InvalidFormException
     */
    public function updateStudentAction(Request $request, $id){

        $studentService = $this->get('student_service');
        $courseService = $this->get('course_service');
        $specialityService = $this->get('speciality_service');

        $studentData = [
            'firstName' => $request->request->get('firstName'),
            'lastName' => $request->request->get('lastName'),
            'email' => $request->request->get('email'),
            'facultyNumber' => $request->request->get('facultyNumber'),
            'educationForm' => $request->request->get('educationForm'),
        ];

        $courseId = $request->request->get('courseId');
        $specialityId = $request->request->get('specialityId');
        $facultyNumber = $request->request->get('facultyNumber');
        $email = $request->request->get('email');

        $courseEntity = $courseService->getCourseById($request->request->get('courseId'));
        $specialityEntity = $specialityService->getSpecialityById($request->request->get('specialityId'));

        $studentEmail = $studentService->getStudentByEmail($request->request->get('email'));
        $studentFacultyNumber = $studentService->getStudentByFacultyNumber($request->request->get('facultyNumber'));

        if(!$courseEntity){
            if(!$courseId){
                throw new BadRequestHttpException("You must add course.");
            }
            throw new BadRequestHttpException("There is no course with this id.");
        }

        if(!$specialityEntity){
            if(!$specialityId){
                throw new BadRequestHttpException("You must add speciality.");
            }
            throw new BadRequestHttpException("There is no speciality with this id.");
        }

        if($studentEmail){
            if(!$email){
                throw new BadRequestHttpException("You must add email.");
            }
            throw new BadRequestHttpException("The email already exists.");
        }

        if($studentFacultyNumber){
            if(!$facultyNumber){
                throw new BadRequestHttpException("You must add a faculty number.");
            }
            throw new BadRequestHttpException("This faculty number already exists.");
        }

        $studentEntity = $studentService->getStudentById($id);

        $studentService->updateStudent($studentEntity,$courseEntity,$specialityEntity,$studentData);

        $studentModel = new StudentModel($studentEntity);

        return new  JsonResponse($studentModel);
    }

    /**
     * @Route("/studentId/{id}")]
     * @Method({"GET"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function getStudentByIdAction(Request $request, $id){

        $studentService = $this->get('student_service');

        $studentEntity = $studentService->getStudentById($id);

        $studentModel = new StudentModel($studentEntity);

        return new JsonResponse($studentModel);
    }
}