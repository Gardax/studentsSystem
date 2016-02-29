<?php
/**
 * Created by PhpStorm.
 * User: suxorr
 * Date: 12/2/15
 * Time: 8:14 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 */

class Role implements RoleInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    protected $role;


    /**
     * @var string
     * @ORM\ManyToMany(targetEntity="User", mappedBy="users")
     */
    protected $users;

    /**
     * Role constructor.
     */
    public function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param Role $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    public function addUser(User $user)
    {
        //if (!in_array($user, $this->users, true)) {
            $this->users[] = $user;
       // }
        return $this;
    }

}