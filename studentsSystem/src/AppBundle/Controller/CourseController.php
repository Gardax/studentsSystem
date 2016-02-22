<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/19/16
 * Time: 11:53 PM
 */

namespace AppBundle\Controller;

use AppBundle\Managers\CourseManager;
use AppBundle\Models\CourseModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CourseController
 * @package AppBundle\Controller
 */
class CourseController extends Controller
{

    const SUCCESS = 1;
    const FAIL = 0;

    /**
     * @Route("/add/course" , name="addCourse")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addCourseAction(Request $request)
    {
        $courseService = $this->get('course_service');
        $courseData = [
            'name' => $request->request->get('name'),
        ];

        $courseEntity = $courseService->addCourse($courseData);
        $courseModel = new CourseModel($courseEntity);

        return new JsonResponse($courseModel);
    }
    /**
     * @Route("/course/edit/{id}", name="updateCourseById")
     * @Method("POST")
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateCourseAction(Request $request, $id){

        $courseService = $this->get('course_service');

        $courseEntity = $courseService->getCourseById($id);

        $courseService->updateCourse($courseEntity,$request->request->get('course'));

        $courseModel = new CourseModel($courseEntity);

        return new  JsonResponse($courseModel);
    }

    /**
     * @Route("/course/delete/{id}", name="deleteCourse")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function deleteCourseAction(Request $request, $id)
    {
        $courseService = $this->get("course_service");

        $courseEntity = $courseService->getCourseById($id);

        $result = self::FAIL;

        if ($courseEntity) {
            $result = $courseService->deleteCourseById($courseEntity);
        }

        $success = $result ? self::SUCCESS : self::FAIL;
        return new JsonResponse(["success" => $success]);
    }
}