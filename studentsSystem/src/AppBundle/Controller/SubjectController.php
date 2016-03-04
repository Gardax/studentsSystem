<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/20/16
 * Time: 8:24 PM
 */

namespace AppBundle\Controller;

use AppBundle\Exceptions\InvalidFormException;
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
 * Class SubjectController
 * @package AppBundle\Controller
 */
class SubjectController extends Controller
{

    const PAGE_SIZE = 10;
    const SUCCESS = 1;
    const FAIL = 0;

    /**
     * @Route("/add/subject" , name="addSubject")
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addSubjectAction(Request $request)
    {
        $subjectService = $this->get('subject_service');

        $subjectData = [
            'name' => $request->request->get('name'),
            'workloadLectures' => $request->request->get('workloadLectures'),
            'workloadExercises' => $request->request->get('workloadExercises'),
        ];

        $subjectEntity = $subjectService->addSubject($subjectData);
        $subjectModel = new SubjectModel($subjectEntity);

        return new JsonResponse($subjectModel);
    }

    /**
     * @Route("/subject/{page}", defaults={"page" = null})]
     * @Method({"GET"})
     *
     * @param Request $request
     * @param $page
     * @return JsonResponse
     */
    public function getSubjectsAction(Request $request, $page)
    {

        $subjectService = $this->get('subject_service');

        $name = $request->query->get('name');

        $subjectEntities = $subjectService->getSubjects($page, self::PAGE_SIZE, $name);

        $subjectModels = array();
        foreach ($subjectEntities as $subject) {
            $model = new SubjectModel($subject);
            $subjectModels[] = $model;
        }

        $totalCount = $subjectService->getSubjects($page, self::PAGE_SIZE, $name, true);
        $data = [
            'subjects' => $subjectModels,
            'totalCount' => $totalCount,
            'page' => $page,
            'itemsPerPage' => ($page == 'all') ? 'all' : self::PAGE_SIZE
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/subject/delete/{id}", name="deleteSubject")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function deleteSubjectAction(Request $request, $id)
    {
        $subjectService = $this->get("subject_service");

        $subjectEntity = $subjectService->getSubjectById($id);

        $result = self::FAIL;

        if ($subjectEntity) {
            $result = $subjectService->deleteSubjectById($subjectEntity);
        }

        $success = $result ? self::SUCCESS : self::FAIL;
        return new JsonResponse(["success" => $success]);
    }

    /**
     * @Route("/subject/edit/{id}", name="updateSubjectById")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws InvalidFormException
     */
    public function updateSubjectAction(Request $request, $id){

        $subjectService = $this->get('subject_service');

        $subjectEntity = $subjectService->getSubjectById($id);

        $subjectService->updateSubject($subjectEntity,$request->request->get('subject'));

        $subjectModel = new SubjectModel($subjectEntity);

        return new  JsonResponse($subjectModel);
    }

    /**
     * @Route("/subjectId/{id}")]
     * @Method({"GET"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function getSubjectById(Request $request, $id){

        $subjectService = $this->get('subject_service');

        $subjectEntity = $subjectService->getSubjectById($id);

        $subjectModel = new SubjectModel($subjectEntity);

        return new JsonResponse($subjectModel);
    }

}