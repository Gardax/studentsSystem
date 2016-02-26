<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/17/16
 * Time: 8:48 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Exceptions\InvalidFormException;
use AppBundle\Models\UserModel;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\UserType;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use AppBundle\Services\UserService;

/**
 * Class UserController
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route("/user/add" , name="addUser")
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     *
     * @throws InvalidFormException
     * @return JsonResponse
     */
    public function registerAction(Request $request) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['validation_groups' => ['registration']] );
        $form->handleRequest($request);

        if(!$form->isValid()){
            throw new InvalidFormException($form);
        }

        $userService = $this->get('user_service');

        $user = $userService->addUser($user);

        $userModel = new UserModel($user);

        return new JsonResponse($userModel);
    }

    /**
     * @Route("/user/authenticate" , name="authenticateUser")
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @throws InvalidFormException
     * @return JsonResponse
     */
    public function authenticateAction(Request $request) {
        $username = $request->request->get('email');
        $password = $request->request->get('password');
        
        $userService = $this->get('user_service');
        $user = $userService->authenticateUser($username, $password);

        $userModel = new UserModel($user);

        return new JsonResponse($userModel);
    }

}