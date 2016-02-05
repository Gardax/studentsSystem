<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Courses
 *
 * @ORM\Table(name="courses", uniqueConstraints={@ORM\UniqueConstraint(name="course_name_unique", columns={"course_name"})})
 * @ORM\Entity
 */
class Courses
{
    /**
     * @var string
     *
     * @ORM\Column(name="course_name", type="string", length=255, nullable=true)
     */
    private $courseName;

    /**
     * @var integer
     *
     * @ORM\Column(name="course_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $courseId;



    /**
     * Set courseName
     *
     * @param string $courseName
     *
     * @return Courses
     */
    public function setCourseName($courseName)
    {
        $this->courseName = $courseName;

        return $this;
    }

    /**
     * Get courseName
     *
     * @return string
     */
    public function getCourseName()
    {
        return $this->courseName;
    }

    /**
     * Get courseId
     *
     * @return integer
     */
    public function getCourseId()
    {
        return $this->courseId;
    }
}
