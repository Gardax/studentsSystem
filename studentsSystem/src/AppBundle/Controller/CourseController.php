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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class CourseController
 * @package AppBundle\Controller
 */
class CourseController extends Controller
{

    const SUCCESS = 1;
    const FAIL = 0;
    const PAGE_SIZE = 10;

    /**
     * @Route("/add/course" , name="addCourse")
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
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

        $existingCourse = $courseService->getCourseByName($courseData['name']);

        if($existingCourse){
            throw new BadRequestHttpException("There is already a course with this name.");
        }

        $courseEntity = $courseService->addCourse($courseData);
        $courseModel = new CourseModel($courseEntity);

        return new JsonResponse($courseModel);
    }
    /**
     * @Route("/course/edit/{id}", name="updateCourse")
     * @Method("PUT")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateCourseAction(Request $request, $id){

        $courseService = $this->get('course_service');

        $courseData = [
          'name' => $request->request->get('name')
        ];

        $courseEntity = $courseService->getCourseById($id);

        if(!$courseEntity){
            throw new BadRequestHttpException("There is no course with this id.");
        }

        $courseService->updateCourse($courseEntity, $courseData);

        $courseModel = new CourseModel($courseEntity);

        return new  JsonResponse($courseModel);
    }

    /**
     * @Route("/course/delete/{id}", name="deleteCourse")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function deleteCourseAction(Request $request, $id)
    {
        $courseService = $this->get("course_service");

        $courseEntity = $courseService->getCourseById($id);

        if(!$courseEntity) {
            throw new BadRequestHttpException('Course not found.');
        }
        $result = $courseService->deleteCourse($courseEntity);

        $success = $result ? self::SUCCESS : self::FAIL;
        return new JsonResponse(["success" => $success]);
    }

    /**
     * @Route("/course/{page}", defaults={"page" = null})]
     * @Method({"GET"})
     *
     * @param Request $request
     * @param $page
     * @return JsonResponse
     */
    public function getCoursesAction(Request $request, $page) {
        $courseService = $this->get('course_service');

        $name = $request->query->get('name');

        $courseEntities = $courseService->getCourses($page, self::PAGE_SIZE, $name);

        $courseModels = array();
        foreach ($courseEntities as $course) {
            $model = new CourseModel($course);
            $courseModels[] = $model;
        }

        $totalCount = $courseService->getCourses($page, self::PAGE_SIZE, $name, true);
        $data = [
            'courses' => $courseModels,
            'totalCount' => $totalCount,
            'page' => $page,
            'itemsPerPage' => ($page == 'all') ? 'all' : self::PAGE_SIZE,
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/course/single/{id}")]
     * @Method({"GET"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function getCourseByIdAction(Request $request, $id){
        $courseService = $this->get('course_service');

        $courseEntity = $courseService->getCourseById($id);
        $courseModel = new CourseModel($courseEntity);

        return new JsonResponse($courseModel);
    }
}