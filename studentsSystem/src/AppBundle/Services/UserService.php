<?php
namespace AppBundle\Services;

use AppBundle\Exceptions\ValidatorException;
use AppBundle\Managers\UserManager;
use AppBundle\Entity\User;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
* Class UserService
* @package AppBundle\Services
*/
class UserService implements UserProviderInterface
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_TEACHER = 'ROLE_TEACHER';

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * UserService constructor.
     * @param UserManager $userManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ValidatorInterface $validator
     */
    public function __construct(
        UserManager $userManager,UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator) {

        $this->userManager = $userManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
    }

    /**
     * @param $userData
     * @return User
     * @throws ValidatorException
     */
    public function addUser($userData){
        $user = new User();

        $user->setUsername($userData['username']);
        $user->setUserFirstName($userData['firstName']);
        $user->setUserLastName($userData['lastName']);
        $user->setEmail($userData['email']);

        $errors = $this->validator->validate($user, null, array('registration'));

        if(count($errors) > 0) {
            throw new ValidatorException($errors);
        }

        $user->setSalt();
        $password = $this->passwordEncoder->encodePassword($user, $userData['password']);
        $user->setPassword($password);

        $user = $this->userManager->addUser($user);

        $roles = $this->getRoles();
        $this->assignAppropriateRoles($user, $userData['roleId'], $roles);

        $this->setUserApiKey($user);

        return $user;
    }

    /**
     * @param $page
     * @param $pageSize
     * @param $filters
     * @param bool $getCount
     * @return User[]
     */
    public function getUsers($page, $pageSize, $filters, $getCount = false, $export = false ){
        $start = 0;
        $end = 0;

        if(!$export) {
            $page = ($page < 1) ? 1 : $page;
            $start = ($page -1) *$pageSize;
            $end = $start + $pageSize;
        }

        $users = $this->userManager->getUsers($start, $end, $filters, $getCount);

        if(!$users){
            throw new BadRequestHttpException("No users found.");
        }
        return $users;
    }


    /**
     * Authenticates a user.
     *
     * @param string $userUniqueIdentifier      The username or the email of the user.
     * @param string $password                  Plain text password.
     * @return User
     */
    public function authenticateUser($userUniqueIdentifier, $password) {
        $user = $this->userManager->getUserByUserNameOrEmail($userUniqueIdentifier);

        if(!$user) {
            throw new Exception('There is no user with this email or username.');
        }

        if(!$this->passwordEncoder->isPasswordValid($user, $password)) {
            throw new Exception('Incorrect password.');
        }

        $user = $this->setUserApiKey($user);

        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function setUserApiKey(User $user) {
        $apiKey = $this->generateApiKey($user);
        $user->setApiKey($apiKey);

        $this->userManager->saveChanges();

        return $user;
    }

    /**
     * @param $id
     * @return User|null|object
     */
    public function getUserById($id){
        $user = $this->userManager->getUserById($id);

        if(!$user){
            throw new NotFoundHttpException("There is no user with this id.");
        }

        return $user;
    }

    /**
     * @param User $user
     * @param $roleId
     * @param $allRoles
     */
    private function assignAppropriateRoles(User $user, $roleId, $allRoles){
        $admin = null;
        $teacher = null;
        $userRole = null;

        foreach($allRoles as $currentRole) {
            if($currentRole->getRole() == self::ROLE_ADMIN) {
               $admin = $currentRole;
            }
            else if($currentRole->getRole() == self::ROLE_TEACHER) {
                $teacher = $currentRole;
            }
            else if($currentRole->getRole() == self::ROLE_USER) {
                $userRole = $currentRole;
            }
        }
        $user->removeRole();

        $user->addRole($userRole);

        if($roleId == $teacher->getId()) {
            $user->addRole($teacher);
        }
        if($roleId == $admin->getId()) {
            $user->addRole($teacher);
            $user->addRole($admin);
        }
    }

    /**
     * @param $apiKey
     * @return mixed
     */
    public function getUsernameForApiKey($apiKey) {
        $user = $this->userManager->getUserByApiKey($apiKey);

        return $user ? $user->getUsername() : null;
    }

    /**
     * @param string $username
     * @return User
     */
    public function loadUserByUsername($username) {
        return $this->userManager->getUserByUsername($username);
    }

    /**
     * Returns ROLE_USER entity.
     *
     * @return \AppBundle\Entity\Role
     */
    protected function getUserRole() {
        return $this->userManager->getUserRole(self::ROLE_USER);
    }

    /**
     * Returns all roles.
     *
     * @param boolean $withoutUserRole
     * @return \AppBundle\Entity\Role[]
     */
    public function getRoles($withoutUserRole = false) {
        return $this->userManager->getRoles($withoutUserRole);
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return 'AppBundle\Entity\User' === $class;
    }

    /**
     * @param User $user
     * @return mixed|string
     */
    private function generateApiKey(User $user) {
        $apiKey = $user->getId();
        $apiKey .= uniqid(md5($user->getUsername() . time()));

        return $apiKey;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function deleteUser(User $user){
        $result = $this->userManager->deleteUser($user);

        return $result;
    }

    public function getRoleByName($role) {
        $roleEntity = $this->userManager->getUserRole($role);

        return $roleEntity;
    }

    public function updateUser(User $user, $userData) {

        if($userData['username'] != $user->getUsername()){
            $user->setUsername($userData['username']);
        }

        if($userData['firstName'] != $user->getUserFirstName()){
            $user->setUserFirstName($userData['firstName']);
        }

        if($userData['lastName'] != $user->getUserLastName()){
            $user->setUserLastName($userData['lastName']);
        }

        if($userData['password'] != ""){
            $password = $this->passwordEncoder->encodePassword($user, $userData['password']);
            $user->setPassword($password);
        }

        if($userData['email'] != $user->getEmail()){
            $user->setEmail($userData['email']);
        }


        $roles = $this->getRoles();
        $this->assignAppropriateRoles($user, $userData['roleId'], $roles);

        $errors = $this->validator->validate($user, null, array('registration'));

        if(count($errors) > 0) {
            throw new ValidatorException($errors);
        }

        $this->userManager->saveChanges();

        return $user;
    }
}