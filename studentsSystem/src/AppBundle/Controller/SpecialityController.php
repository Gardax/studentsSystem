<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/20/16
 * Time: 12:19 AM
 */

namespace AppBundle\Controller;

use AppBundle\Models\SpecialityModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SpecialityController
 * @package AppBundle\Controller
 */
class SpecialityController extends Controller
{
    const PAGE_SIZE = 10;
    const SUCCESS = 1;
    const FAIL = 0;

    /**
     * @Route("/add/speciality" , name="addSpeciality")
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addSpecialityAction(Request $request)
    {
        $specialityService = $this->get('speciality_service');
        $specialityData = [
            'longName' => $request->request->get('longName'),
            'shortName' => $request->request->get('shortName'),
        ];

        $specialityEntity = $specialityService->addSpeciality($specialityData);

        $specialityModel = new SpecialityModel($specialityEntity);

        return new JsonResponse($specialityModel);
    }

    /**
     * @Route("/speciality/{page}", defaults={"page" = null})]
     * @Method({"GET"})
     * @Security("has_role('ROLE_TEACHER')")
     *
     * @param Request $request
     * @param $page
     * @return JsonResponse
     */
    public function getSpecialityAction(Request $request, $page){

        $specialityService = $this->get('speciality_service');

        $filters = [
            'longName'  => $request->query->get('longName'),
            'shortName' => $request->query->get('shortName'),
        ];

        $specialityEntities = $specialityService->getSpecialities($page, self::PAGE_SIZE, $filters);

        $specialityModels = array();
        foreach ($specialityEntities as $speciality) {
            $model = new SpecialityModel($speciality);
            $specialityModels[] = $model;
        }

        $totalCount = $specialityService->getSpecialities($page, self::PAGE_SIZE, $filters, true);
        $data = [
            'specialities' => $specialityModels,
            'totalCount' => $totalCount,
            'page' => $page
        ];

        return new JsonResponse($data);
    }

}