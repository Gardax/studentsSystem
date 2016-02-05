<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Students
 *
 * @ORM\Table(name="students", uniqueConstraints={@ORM\UniqueConstraint(name="student_email_UNIQUE", columns={"student_email"}), @ORM\UniqueConstraint(name="student_name_fn_UNIQUE", columns={"student_fname", "student_lname", "student_fnumber"})}, indexes={@ORM\Index(name="student_course_id", columns={"student_course_id"}), @ORM\Index(name="student_speciality_id", columns={"student_speciality_id"})})
 * @ORM\Entity
 */
class Students
{
    /**
     * @var integer
     *
     * @ORM\Column(name="student_course_id", type="integer", nullable=false)
     */
    private $studentCourseId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="student_speciality_id", type="integer", nullable=false)
     */
    private $studentSpecialityId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="student_fname", type="string", length=45, nullable=true)
     */
    private $studentFname;

    /**
     * @var string
     *
     * @ORM\Column(name="student_lname", type="string", length=45, nullable=true)
     */
    private $studentLname;

    /**
     * @var string
     *
     * @ORM\Column(name="student_email", type="string", length=64, nullable=true)
     */
    private $studentEmail;

    /**
     * @var integer
     *
     * @ORM\Column(name="student_fnumber", type="integer", nullable=true)
     */
    private $studentFnumber = '0000000000';

    /**
     * @var string
     *
     * @ORM\Column(name="student_education_form", type="string", nullable=false)
     */
    private $studentEducationForm = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="student_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $studentId;



    /**
     * Set studentCourseId
     *
     * @param integer $studentCourseId
     *
     * @return Students
     */
    public function setStudentCourseId($studentCourseId)
    {
        $this->studentCourseId = $studentCourseId;

        return $this;
    }

    /**
     * Get studentCourseId
     *
     * @return integer
     */
    public function getStudentCourseId()
    {
        return $this->studentCourseId;
    }

    /**
     * Set studentSpecialityId
     *
     * @param integer $studentSpecialityId
     *
     * @return Students
     */
    public function setStudentSpecialityId($studentSpecialityId)
    {
        $this->studentSpecialityId = $studentSpecialityId;

        return $this;
    }

    /**
     * Get studentSpecialityId
     *
     * @return integer
     */
    public function getStudentSpecialityId()
    {
        return $this->studentSpecialityId;
    }

    /**
     * Set studentFname
     *
     * @param string $studentFname
     *
     * @return Students
     */
    public function setStudentFname($studentFname)
    {
        $this->studentFname = $studentFname;

        return $this;
    }

    /**
     * Get studentFname
     *
     * @return string
     */
    public function getStudentFname()
    {
        return $this->studentFname;
    }

    /**
     * Set studentLname
     *
     * @param string $studentLname
     *
     * @return Students
     */
    public function setStudentLname($studentLname)
    {
        $this->studentLname = $studentLname;

        return $this;
    }

    /**
     * Get studentLname
     *
     * @return string
     */
    public function getStudentLname()
    {
        return $this->studentLname;
    }

    /**
     * Set studentEmail
     *
     * @param string $studentEmail
     *
     * @return Students
     */
    public function setStudentEmail($studentEmail)
    {
        $this->studentEmail = $studentEmail;

        return $this;
    }

    /**
     * Get studentEmail
     *
     * @return string
     */
    public function getStudentEmail()
    {
        return $this->studentEmail;
    }

    /**
     * Set studentFnumber
     *
     * @param integer $studentFnumber
     *
     * @return Students
     */
    public function setStudentFnumber($studentFnumber)
    {
        $this->studentFnumber = $studentFnumber;

        return $this;
    }

    /**
     * Get studentFnumber
     *
     * @return integer
     */
    public function getStudentFnumber()
    {
        return $this->studentFnumber;
    }

    /**
     * Set studentEducationForm
     *
     * @param string $studentEducationForm
     *
     * @return Students
     */
    public function setStudentEducationForm($studentEducationForm)
    {
        $this->studentEducationForm = $studentEducationForm;

        return $this;
    }

    /**
     * Get studentEducationForm
     *
     * @return string
     */
    public function getStudentEducationForm()
    {
        return $this->studentEducationForm;
    }

    /**
     * Get studentId
     *
     * @return integer
     */
    public function getStudentId()
    {
        return $this->studentId;
    }
}
