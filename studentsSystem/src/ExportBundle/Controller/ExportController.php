<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 3/15/16
 * Time: 12:06 AM
 */

namespace ExportBundle\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\ORM\EntityManager;

class ExportController extends Controller
{

    /**
     * @Route("/csv/users")
     */
    public function userCSVAction()
    {
        $service = $this->get('user_service');

        $users = $service->getUsers(0, 0, [], false, true);

        $response = new StreamedResponse();

        $response->setCallback(
            function () use ($users) {
                $handle = fopen('php://output', 'r+');

                $data = array(
                    'id',
                    'username',
                    'email'
                );
                fputcsv($handle, $data, ';');

                foreach ($users as $user) {
                    $data = array(
                        $user->getId(),
                        $user->getUsername(),
                        $user->getEmail()
                    );
                    fputcsv($handle, $data, ';');
                }
                fclose($handle);
            }
        );

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="users.csv"');

        return $response;
    }

    /**
     * @Route("/csv/students")
     */
    public function studentCSVAction()
    {
        $service = $this->get('student_service');

        $students = $service->getStudents(0, 0, [], false, false, true);

        $response = new StreamedResponse();

        $response->setCallback(
            function () use ($students) {
                $handle = fopen('php://output', 'r+');

                $data = array(
                    'Id',
                    'First name',
                    'Last name',
                    'Email',
                    'Faculty number'
                );
                fputcsv($handle, $data, ';');

                foreach ($students as $student) {
                    $data = array(
                        $student->getId(),
                        $student->getFirstName(),
                        $student->getLastName(),
                        $student->getEmail(),
                        $student->getFacultyNumber()
                    );
                    fputcsv($handle, $data, ';');
                }
                fclose($handle);
            }
        );

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="students.csv"');

        return $response;
    }

    /**
     * @Route("/csv/courses")
     */
    public function courseCSVAction()
    {
        $service = $this->get('course_service');

        $courses = $service->getCourses('all', 0);

        $response = new StreamedResponse();

        $response->setCallback(
            function () use ($courses) {
                $handle = fopen('php://output', 'r+');

                $data = array(
                    'Id',
                    'Name'
                );
                fputcsv($handle, $data, ';');

                foreach ($courses as $course) {
                    $data = array(
                        $course->getId(),
                        $course->getName()
                    );
                    fputcsv($handle, $data, ';');
                }
                fclose($handle);
            }
        );

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="courses.csv"');

        return $response;
    }

    /**
     * @Route("/csv/subjects")
     */
    public function subjectCSVAction()
    {
        $service = $this->get('subject_service');

        $subjects = $service->getAllSubjects();

        $response = new StreamedResponse();

        $response->setCallback(
            function () use ($subjects) {
                $handle = fopen('php://output', 'r+');

                $data = array(
                    'Id',
                    'Name',
                    'Workload Lectures',
                    'Workload Exercises'
                );
                fputcsv($handle, $data, ';');

                foreach ($subjects as $subject) {
                    $data = array(
                        $subject->getId(),
                        $subject->getName(),
                        $subject->getWorkloadLectures(),
                        $subject->getWorkloadExercises()
                    );
                    fputcsv($handle, $data, ';');
                }
                fclose($handle);
            }
        );

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="subjects.csv"');

        return $response;
    }

    /**
     * @Route("/csv/specialities")
     */
    public function specialityCSVAction()
    {
        $service = $this->get('speciality_service');

        $specialities = $service->getSpecialities('all', 0, []);

        $response = new StreamedResponse();

        $response->setCallback(
            function () use ($specialities) {
                $handle = fopen('php://output', 'r+');

                $data = array(
                    'Id',
                    'Long name',
                    'Short name'
                );
                fputcsv($handle, $data, ';');

                foreach ($specialities as $speciality) {
                    $data = array(
                        $speciality->getId(),
                        $speciality->getSpecialityLongName(),
                        $speciality->getSpecialityShortName()
                    );
                    fputcsv($handle, $data, ';');
                }
                fclose($handle);
            }
        );

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="specialities.csv"');

        return $response;
    }

    /**
     * @Route("/csv/assessments")
     */
    public function assessmentCSVAction()
    {
        $assessmentService = $this->get('student_assessment_service');

        $assessments = $assessmentService->getStudentAssessments(0, 0, [], false, true);

        $response = new StreamedResponse();

        $response->setCallback(
            function () use ($assessments) {
                $handle = fopen('php://output', 'r+');

                $data = array(
                    'Id',
                    'First name',
                    'Last name',
                    'Subject',
                    'Assessment'
                );
                fputcsv($handle, $data, ';');
                foreach ($assessments as $assessment) {
                    $data = array(
                        $assessment->getId(),
                        $assessment->getStudent()->getFirstName(),
                        $assessment->getStudent()->getLastName(),
                        $assessment->getSubject()->getName(),
                        $assessment->getAssessment()
                    );
                    fputcsv($handle, $data, ';');
                }

                fclose($handle);
            }

        );

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="assessments.csv"');

        return $response;
    }

}