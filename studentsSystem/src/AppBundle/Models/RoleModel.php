<?php

namespace AppBundle\Models;


use AppBundle\Entity\Role;
use AppBundle\Services\UserService;

class RoleModel
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $roleName;

    public function __construct(Role $role){
        $this->setId($role->getId());

        $name = 'User';
        switch($role->getRole()){
            case UserService::ROLE_TEACHER: $name = 'Преподавател'; break;
            case UserService::ROLE_ADMIN: $name = 'Администратор'; break;

        }
        $this->setRoleName($name);
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
}