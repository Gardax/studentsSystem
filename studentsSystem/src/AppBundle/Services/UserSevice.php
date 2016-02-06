<?php

namespace AppBundle\Services;
use AppBundle\Managers\UserManager;
use AppBundle\Entity\Users;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
/**
* Class UserService
* @package AppBundle\Services
*/
class UserService implements UserProviderInterface
{
    /**
    * @var UserManager
    */
    protected $userManager;
    /**
    * UserService constructor.
    * @param UserManager $userManager
    */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }
    public function addUser($userData)
    {

        if(count($userData['username']) < 3){
            throw new \Exception("The username must be more then 3 symbols.");
        }
        if(count($userData['email']) < 5){
            throw new \Exception("There is a problem with your e-mail. Please try again.");
        }
        if(count($userData['password']) < 5){
            throw new \Exception("The password must be more then 5 symbols.");
        }
        if(!isset($userData['username']) || !isset($userData['email']) || !isset($userData['password'])){
            throw new \Exception("Please enter your username.");
        }
        $userEntity = new Users();
        $userEntity->setUserFname($userData['userFname']);
        $userEntity->setUserLname($userData['userLname']);
        $userEntity->setUserName($userData['username']);
        $userEntity->setUserEmail($userData['email']);
        $userEntity->setUserPassword($userData['password']);
        $this->userManager->addUser($userEntity);
        $this->userManager->saveChanges();
        return $userEntity;
    }
    public function authenticate($userData)
    {
        return true;
    }
    public function getUserById($id)
    {
        $id = $this->validateId($id);
        $user = $this->userManager->getUserById($id);
        if(!$user){
            throw new Exception("Recipe not found.");
        }
        return $user;
    }
    /**
    * @param $id
    * @return mixed
    * @throws \Exception
    */
    public function validateId($id)
    {
        if(!$id || !is_numeric($id))
        {
            throw new \Exception("The id must be numeric.");
        }elseif($id < 1){
            throw new \Exception("The user identifier cannot be a negative number.");
        }
        return $id;
    }
    public function getUsernameForApiKey($apiKey){
        $user = $this->userManager->getUserByApiKey($apiKey);
        if( !$user ) {
            return null;
        }
        return $user->getUsername();
    }
    public function loadUserByUsername($username)
    {
        return $this->userManager->getUserByUsername($username);
    }
    public function refreshUser(UserInterface $user)
    {
// this is used for storing authentication in the session
// but in this example, the token is sent in each request,
// so authentication can be stateless. Throwing this exception
// is proper to make things stateless
        throw new UnsupportedUserException();
    }
    public function supportsClass($class)
    {
        return 'CookWithMeBundle\Entity\User' === $class;
    }
}