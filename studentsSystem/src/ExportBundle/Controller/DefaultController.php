<?php

namespace ExportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/homepage")
     */
    public function indexAction()
    {
        $service = $this->get('student_service');
        $subjectsService = $this->get('subject_service');

        $studentEntities = $service->getStudents(0, 0, [], true, false, true);
        $subjects = $subjectsService->getSubjects(1, 3);

        $html = $this->renderView(
            'ExportBundle:Default:homepage.html.twig',
            array(
                'students' => $studentEntities,
                'subjects' => $subjects
            )
        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="homepage.pdf"'
            )
        );
    }

    /**
     * @Route("/courses")
     * @Security("has_role('ROLE_TEACHER')")
     */
    public function courseAction()
    {
        $service = $this->get('course_service');

        $courses = $service->getCourses('all', 0);

        $html = $this->renderView(
            'ExportBundle:Default:courses.html.twig',
            array(
                'courses' => $courses
            )
        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="courses.pdf"'
            )
        );
    }

    /**
     * @Route("/specialities")
     * @Security("has_role('ROLE_TEACHER')")
     */
    public function specialityAction()
    {
        $service = $this->get('speciality_service');

        $specialities = $service->getSpecialities('all', 0, []);

        $html = $this->renderView(
            'ExportBundle:Default:specialities.html.twig',
            array(
                'specialities' => $specialities
            )
        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="specialities.pdf"'
            )
        );
    }

    /**
     * @Route("/subjects")
     * @Security("has_role('ROLE_TEACHER')")
     */
    public function subjectsAction()
    {
        $service = $this->get('subject_service');

        $subjects = $service->getAllSubjects();

        $html = $this->renderView(
            'ExportBundle:Default:subjects.html.twig',
            array(
                'subjects' => $subjects
            )
        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="subjects.pdf"'
            )
        );
    }

    /**
     * @Route("/students")
     * @Security("has_role('ROLE_TEACHER')")
     */
    public function studentsAction()
    {
        $service = $this->get('student_service');

        $studentEntities = $service->getStudents(0, 0, [], false, false, true);

        $html = $this->renderView(
            'ExportBundle:Default:students.html.twig',
            array(
                'students' => $studentEntities
            )
        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="students.pdf"'
            )
        );
    }

    /**
     * @Route("/assessments")
     * @Security("has_role('ROLE_TEACHER')")
     */
    public function assessmentsAction()
    {
        $service = $this->get('student_assessment_service');

        $assessments = $service->getStudentAssessments(0, 0, [], false, true);

        $html = $this->renderView(
            'ExportBundle:Default:grades.html.twig',
            array(
                'assessments' => $assessments
            )
        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="assessments.pdf"'
            )
        );
    }

    /**
     * @Route("/users")
     * @Security("has_role('ROLE_TEACHER')")
     */
    public function usersAction()
    {
        $service = $this->get('user_service');

        $users = $service->getUsers(0, 0, [], false, true);

        $html = $this->renderView(
            'ExportBundle:Default:users.html.twig',
            array(
                'users' => $users
            )
        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="users.pdf"'
            )
        );
    }
}
