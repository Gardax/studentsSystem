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
    const PAGE_SIZE = 5;
    const SUCCESS = 1;
    const FAIL = 0;

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

        $userService = $this->get('user_service');

        $userData = [
            'username' => $request->request->get('username'),
            'firstName' => $request->request->get('firstName'),
            'lastName' => $request->request->get('lastName'),
            'password' => $request->request->get('password'),
            'confirmPassword' => $request->request->get('confirmPassword'),
            'email' => $request->request->get('email'),
            'roleId' => $request->request->get('roleId')
        ];

        if($userData['password'] != $userData['confirmPassword']){
            throw new BadRequestHttpException("Паролите не съвпадат.");
        }

        $userEntity = $userService->addUser($userData);

        $userModel = new UserModel($userEntity);

        return new JsonResponse($userModel);
    }

    /**
     * @Route("/user/{page}", defaults={"page" = null})]
     * @Method({"GET"})
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param $page
     * @return JsonResponse
     */
    public function getUsersAction(Request $request, $page){
        $userService = $this->get('user_service');

        $filters = [
            'username'  => $request->query->get('username'),
            'email' => $request->query->get('email')
        ];

        $userEntities = $userService->getUsers($page, self::PAGE_SIZE, $filters);

        $userModels = array();
        foreach ($userEntities as $user) {
            $model = new UserModel($user);
            $userModels[] = $model;
        }

        $totalCount = $userService->getUsers($page, self::PAGE_SIZE, $filters, true);

        $data = [
            'users' => $userModels,
            'totalCount' => $totalCount,
            'page' => $page,
            'itemsPerPage' => self::PAGE_SIZE
        ];

        return new JsonResponse($data);
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

    /**
     * @Route("/user/single/{id}")]
     * @Method({"GET"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function getUserById(Request $request, $id){
        $userService = $this->get('user_service');

        $userEntity = $userService->getUserById($id);
        $userModel = new UserModel($userEntity);

        return new JsonResponse($userModel);
    }

    /**
     * @Route("/user/delete/{id}", name="deleteUser")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function deleteUserAction(Request $request, $id) {

        $userService = $this->get("user_service");

        $user = $userService->getUserById($id);
        $result = $userService->deleteUser($user);

        $success = $result ? self::SUCCESS : self::FAIL;
        return new JsonResponse(["success" => $success]);
    }

}