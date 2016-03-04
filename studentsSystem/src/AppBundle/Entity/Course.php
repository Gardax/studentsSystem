<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Courses
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Course
{
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(groups={"edit", "add"}, message="Name cannot be blank.")
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var @ORM\OneToMany(targetEntity="Student", mappedBy="course", cascade={"remove"})
     */
    protected $students;

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Student[]
     */
    public function getStudents()
    {
        return $this->students;
    }
}