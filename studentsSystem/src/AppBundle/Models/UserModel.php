<?php

/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/17/16
 * Time: 8:56 PM
 */

namespace AppBundle\Models;

use AppBundle\Entity\User;
use AppBundle\Services\UserService;

/**
 * Class UserModel
 * @package AppBundle\Models
 */
class UserModel
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $userFirstName;

    /**
     * @var string
     */
    public $userLastName;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $apiKey;

    /**
     * @var string
     */
    public $roleName;

    /**
     * UserModel constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->setId($user->getId());
        $this->setUsername($user->getUsername());
        $this->setUserFirstName($user->getUserFirstName());
        $this->setUserLastName($user->getUserLastName());
        $this->setEmail($user->getEmail());
        $this->setPassword($user->getPassword());
        $this->setApiKey($user->getApiKey());
        $this->setRoleName($this->determineTheBiggestRoleName($user));
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->userFirstName;
    }

    /**
     * @param string $userFirstName
     */
    public function setUserFirstName($userFirstName)
    {
        $this->userFirstName = $userFirstName;
    }

    /**
     * @return string
     */
    public function getUserLastName()
    {
        return $this->userLastName;
    }

    /**
     * @param string $userLastName
     */
    public function setUserLastName($userLastName)
    {
        $this->userLastName = $userLastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * @param string $roleName
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;
    }

    private function determineTheBiggestRoleName(User $user) {
        $containsRoleAdmin = false;
        $containsRoleTeacher = false;
        foreach($user->getRoles() as $role) {
            if($role->getRole() == UserService::ROLE_ADMIN) {
                $containsRoleAdmin = true;
                break;
            }
            if($role->getRole() == UserService::ROLE_TEACHER) {
                $containsRoleTeacher = true;
            }
        }

        //TODO: Extract the hardcoded string as constants!
        if($containsRoleAdmin) return 'Admin';
        if($containsRoleTeacher) return 'Teacher';

        return 'Student';
    }
}