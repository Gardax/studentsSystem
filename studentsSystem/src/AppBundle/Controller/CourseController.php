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
}