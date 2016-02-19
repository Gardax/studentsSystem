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
    const PAGE_SIZE = 10;

    /**
     * @Route("/student/{page}", defaults={"page" = 1})]
     * @Method({"GET"})
     * @param Request $request
     * @param $page
     * @return JsonResponse
     */
    public function getStudentsAction(Request $request, $page){

        $service = $this->get('student_service');

        $username  = $request->query->get('username');
        $speciality = $request->query->get('speciality');
        $course = $request->query->get('course');

        $studentEntities = $service->getStudents($page, self::PAGE_SIZE, $username,$speciality,$course);

        $studentModels = array();
        foreach ($studentEntities as $student) {
            $model = new StudentModel($student);
            $studentModels[] = $model;
        }
        return new JsonResponse($studentModels);
    }
}