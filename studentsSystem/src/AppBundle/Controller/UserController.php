<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/6/16
 * Time: 5:02 PM
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class UserController
 * @package AppBundle\Controller
 */
class UserController extends FOSRestController
{

    /**
     * Create a User from the submitted data.<br/>
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new user from the submitted data.",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param ParamFetcher $paramFetcher ParamFetcher
     *
     * @RequestParam(name="username", nullable=false, strict=true, description="Username.")
     * @RequestParam(name="email", nullable=false, strict=true, description="Email.")
     * @RequestParam(name="name", nullable=false, strict=true, description="Name.")
     * @RequestParam(name="lastname", nullable=false, strict=true, description="Lastname.")
     * @RequestParam(name="password", nullable=false, strict=true, description="Plain Password.")
     *
     * @return View
     */
    public function postUserAction(ParamFetcher $paramFetcher){

        $userManager = $this->container->get('fos_user.util.user_manipulator')
            ->create(

            );

        $user = $userManager->createUser();


    }


}