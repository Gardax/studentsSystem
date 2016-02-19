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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SpecialityController
 * @package AppBundle\Controller
 */
class SpecialityController extends Controller
{
    /**
     * @Route("/add/speciality" , name="addSpeciality")
     * @Method({"POST"})
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

}