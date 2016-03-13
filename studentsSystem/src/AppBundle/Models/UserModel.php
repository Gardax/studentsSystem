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
     * @var RoleModel
     */
    public $role;

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
        $role = $this->determineTheBiggestRole($user);
        if($role) {
            $this->setRole(new RoleModel($role));
        }
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
     * @return RoleModel
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param RoleModel $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @param User $user
     * @return \AppBundle\Entity\Role|null
     */
    private function determineTheBiggestRole(User $user) {
        $biggestRole = null;
        foreach($user->getRoles() as $role) {
            if($role->getRole() == UserService::ROLE_ADMIN) {
                $biggestRole = $role;
                break;
            }
            if($role->getRole() == UserService::ROLE_TEACHER) {
                $biggestRole = $role;
            }
        }

        return $biggestRole;
    }
}