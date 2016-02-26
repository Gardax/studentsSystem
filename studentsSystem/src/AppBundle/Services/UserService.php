<?php
namespace AppBundle\Services;

use AppBundle\Managers\UserManager;
use AppBundle\Entity\User;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
* Class UserService
* @package AppBundle\Services
*/
class UserService implements UserProviderInterface
{
    const ROLE_USER = 'ROLE_USER';

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * UserService constructor.
     * @param UserManager $userManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserManager $userManager, UserPasswordEncoderInterface $passwordEncoder) {
        $this->userManager = $userManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $user
     * @return User
     */
    public function addUser(User $user){
        $user->setSalt();
        $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        $roleUser = $this->getUserRole();
        $user->addRole($roleUser);

        $user = $this->userManager->addUser($user);

        $this->setUserApiKey($user);

        return $user;
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

        return $user;
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
}