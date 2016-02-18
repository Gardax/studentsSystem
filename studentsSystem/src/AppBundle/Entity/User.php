<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(groups={"registration", "login"}, message="Username cannot be blank.")
     * @Assert\Length(
     *     min=3,
     *     max=25,
     *     minMessage="Username should be between 3 and 25 characters.",
     *     maxMessage="Username should be between 3 and 25 characters.",
     *     groups={"registration"}
     * )
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(groups={"registration"}, message="First name cannot be blank.")
     * @Assert\Length(
     *     min=3,
     *     max=25,
     *     minMessage="First name should be between 3 and 25 characters.",
     *     maxMessage="First name should be between 3 and 25 characters.",
     *     groups={"registration"}
     * )
     */
    protected $userFirstName;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(groups={"registration"}, message="Last name cannot be blank.")
     * @Assert\Length(
     *     min=3,
     *     max=25,
     *     minMessage="Last name should be between 3 and 25 characters.",
     *     maxMessage="Last name should be between 3 and 25 characters.",
     *     groups={"registration"}
     * )
     */
    protected $userLastName;

    /**
     * @ORM\Column(type="string", length=60, unique=true, nullable=true)
     * @Assert\Email(groups={"registration"}, message="Invalid email address.")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(groups={"login", "register"}, message="Password cannot be blank.")
     * @Assert\Length(min=4, max = 100, groups={"registration"})
     */
    protected $password;

    /**
     * @ORM\Column(type="string", unique=true, nullable=true )
     */
    private $apiKey;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $salt;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinTable(name="users_roles")
     */
    protected $roles;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUserFirstName()
    {
        return $this->userFirstName;
    }

    /**
     * @param mixed $userFirstName
     */
    public function setUserFirstName($userFirstName)
    {
        $this->userFirstName = $userFirstName;
    }

    /**
     * @return mixed
     */
    public function getUserLastName()
    {
        return $this->userLastName;
    }

    /**
     * @param mixed $userLastName
     */
    public function setUserLastName($userLastName)
    {
        $this->userLastName = $userLastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt() {
        $this->salt = $this->generateSalt();
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }
    /**
     * @param string $roles
     */
    public function setRoles($roles)
    {
        $this->roles[] = $roles;
    }

    /**
     * @param $role
     * @return $this
     */
    public function addRole($role)
    {
        //if (!in_array($role, $this->roles, true)) {
        $this->roles[] = $role;
        // }
        return $this;
    }
    /**
     * @return array
     */
    private function generateSalt(){
        $generatedSalt = uniqid($this->getUsername());
        return $generatedSalt;
    }

    public function eraseCredentials()
    {
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }
    /**
     * @param string $serialized
     */
    public function unSerialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }
}
