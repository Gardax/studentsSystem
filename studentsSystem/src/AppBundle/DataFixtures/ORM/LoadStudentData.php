<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/22/16
 * Time: 10:38 PM
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\StudentAssessment;
use AppBundle\Entity\Subject;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Student;
use AppBundle\Entity\Course;
use AppBundle\Entity\Speciality;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadStudentData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $course1 = new Course();
        $course1->setName('Първи');

        $manager->persist($course1);

        $course2 = new Course();
        $course2->setName('Втори');

        $manager->persist($course2);

        $course3 = new Course();
        $course3->setName('Трети');

        $manager->persist($course3);

        $course4 = new Course();
        $course4->setName('Четвърти');

        $manager->persist($course4);

        $speciality1 = new Speciality();
        $speciality1->setSpecialityLongName('Математика и Информатика');
        $speciality1->setSpecialityShortName('МИ');

        $manager->persist($speciality1);

        $speciality2 = new Speciality();
        $speciality2->setSpecialityLongName('Софтуерни технологии и дизайн');
        $speciality2->setSpecialityShortName('СТД');

        $manager->persist($speciality2);

        $speciality3 = new Speciality();
        $speciality3->setSpecialityLongName('Бизнес информационни технологии');
        $speciality3->setSpecialityShortName('БИТ');

        $manager->persist($speciality3);

        $speciality4 = new Speciality();
        $speciality4->setSpecialityLongName('Информатика');
        $speciality4->setSpecialityShortName('И');

        $manager->persist($speciality4);

        $speciality5 = new Speciality();
        $speciality5->setSpecialityLongName('Математика');
        $speciality5->setSpecialityShortName('М');

        $manager->persist($speciality5);

        $speciality6 = new Speciality();
        $speciality6->setSpecialityLongName('Информационни технологии, математика и образователен мениджмънт ');
        $speciality6->setSpecialityShortName('ИТМОМ');

        $manager->persist($speciality6);

        $speciality7 = new Speciality();
        $speciality7->setSpecialityLongName('Бизнес математика');
        $speciality7->setSpecialityShortName('БМ');

        $manager->persist($speciality7);

        $speciality8 = new Speciality();
        $speciality8->setSpecialityLongName('Приложна математика');
        $speciality8->setSpecialityShortName('ПМ');

        $manager->persist($speciality8);

        $speciality9 = new Speciality();
        $speciality9->setSpecialityLongName('Химия');
        $speciality9->setSpecialityShortName('Х');

        $manager->persist($speciality9);

        $speciality10 = new Speciality();
        $speciality10->setSpecialityLongName('Компютърна химия');
        $speciality10->setSpecialityShortName('КХ');

        $manager->persist($speciality10);

        $speciality11 = new Speciality();
        $speciality11->setSpecialityLongName('Медицинска химия');
        $speciality11->setSpecialityShortName('МХ');

        $manager->persist($speciality11);

        $student1 = new Student();
        $student1->setCourse($course1);
        $student1->setSpeciality($speciality8);
        $student1->setFirstName('Марио');
        $student1->setLastName('Христев');
        $student1->setEmail('hristevmario@gmail.com');
        $student1->setFacultyNumber('1401181006');

        $manager->persist($student1);

        $student2 = new Student();
        $student2->setCourse($course2);
        $student2->setSpeciality($speciality2);
        $student2->setFirstName('Георги');
        $student2->setLastName('Георгиев');
        $student2->setEmail('gardax@gmail.com');
        $student2->setFacultyNumber('1401181015');

        $manager->persist($student2);

        $student3 = new Student();
        $student3->setCourse($course3);
        $student3->setSpeciality($speciality3);
        $student3->setFirstName('Кристиан');
        $student3->setLastName('Башев');
        $student3->setEmail('dahacka@gmail.com');
        $student3->setFacultyNumber('1401181038');

        $manager->persist($student3);

        $student4 = new Student();
        $student4->setCourse($course4);
        $student4->setSpeciality($speciality4);
        $student4->setFirstName('Боряна');
        $student4->setLastName('Котева');
        $student4->setEmail('bobikoteva@gmail.com');
        $student4->setFacultyNumber('1401181010');

        $manager->persist($student4);

        $student5 = new Student();
        $student5->setCourse($course3);
        $student5->setSpeciality($speciality4);
        $student5->setFirstName('Жеко');
        $student5->setLastName('Николов');
        $student5->setEmail('jekjik@gmail.com');
        $student5->setFacultyNumber('1401181029');

        $manager->persist($student5);

        $student6 = new Student();
        $student6->setCourse($course2);
        $student6->setSpeciality($speciality6);
        $student6->setFirstName('Антон');
        $student6->setLastName('Капанов');
        $student6->setEmail('tonibonboni@gmail.com');
        $student6->setFacultyNumber('1401181040');

        $manager->persist($student6);

        $student7 = new Student();
        $student7->setCourse($course2);
        $student7->setSpeciality($speciality4);
        $student7->setFirstName('Мира');
        $student7->setLastName('Спасова');
        $student7->setEmail('mirkaBibirka@gmail.com');
        $student7->setFacultyNumber('1401181011');

        $manager->persist($student7);

        $student8 = new Student();
        $student8->setCourse($course2);
        $student8->setSpeciality($speciality2);
        $student8->setFirstName('Ирина');
        $student8->setLastName('Джоголова');
        $student8->setEmail('davis94@gmail.com');
        $student8->setFacultyNumber('1401181017');

        $manager->persist($student8);

        $student8 = new Student();
        $student8->setCourse($course1);
        $student8->setSpeciality($speciality7);
        $student8->setFirstName('Веселина');
        $student8->setLastName('Славчева');
        $student8->setEmail('vesi4@gmail.com');
        $student8->setFacultyNumber('1401181034');

        $manager->persist($student8);

        $student9 = new Student();
        $student9->setCourse($course3);
        $student9->setSpeciality($speciality10);
        $student9->setFirstName('Галин');
        $student9->setLastName('Иванов');
        $student9->setEmail('fiki-bum@gmail.com');
        $student9->setFacultyNumber('1401181060');

        $manager->persist($student9);

        $student10 = new Student();
        $student10->setCourse($course3);
        $student10->setSpeciality($speciality10);
        $student10->setFirstName('Катерина');
        $student10->setLastName('Попова');
        $student10->setEmail('azSamKobra@gmail.com');
        $student10->setFacultyNumber('1401181048');

        $manager->persist($student10);

        $student11 = new Student();
        $student11->setCourse($course3);
        $student11->setSpeciality($speciality10);
        $student11->setFirstName('Неджад');
        $student11->setLastName('Сюлейман');
        $student11->setEmail('dedo@gmail.com');
        $student11->setFacultyNumber('1401181045');

        $manager->persist($student11);


        $subject1 = new Subject();
        $subject1->setName('Увод в програмирането (С#)');
        $subject1->setWorkloadLectures('40');
        $subject1->setWorkloadExercises('60');

        $manager->persist($subject1);

        $subject2 = new Subject();
        $subject2->setName('Линейна алгебра и аналитична геометрия');
        $subject2->setWorkloadLectures('60');
        $subject2->setWorkloadExercises('60');

        $manager->persist($subject2);

        $subject3 = new Subject();
        $subject3->setName('Увод в информационните технологии');
        $subject3->setWorkloadLectures('40');
        $subject3->setWorkloadExercises('60');

        $manager->persist($subject3);

        $subject4 = new Subject();
        $subject4->setName('Английски език');
        $subject4->setWorkloadLectures('30');
        $subject4->setWorkloadExercises('30');

        $manager->persist($subject4);

        $subject5 = new Subject();
        $subject5->setName('Създаване на ГПИ (С#)');
        $subject5->setWorkloadLectures('40');
        $subject5->setWorkloadExercises('60');

        $manager->persist($subject5);

        $subject6 = new Subject();
        $subject6->setName('Основи на графичния дизайн');
        $subject6->setWorkloadLectures('40');
        $subject6->setWorkloadExercises('60');

        $manager->persist($subject6);

        $subject7 = new Subject();
        $subject7->setName('Софтуерни системи по математика');
        $subject7->setWorkloadLectures('40');
        $subject7->setWorkloadExercises('60');

        $manager->persist($subject7);

        $subject8 = new Subject();
        $subject8->setName('Спорт');
        $subject8->setWorkloadLectures('40');
        $subject8->setWorkloadExercises('60');

        $manager->persist($subject8);

        $sa1 = new StudentAssessment();
        $sa1->setWorkloadExercises(20);
        $sa1->setWorkloadLectures(30);
        $sa1->setAssessment(2);
        $sa1->setSubject($subject1);
        $sa1->setStudent($student1);

        $manager->persist($sa1);

        $sa2 = new StudentAssessment();
        $sa2->setWorkloadExercises(20);
        $sa2->setWorkloadLectures(30);
        $sa2->setAssessment(2);
        $sa2->setSubject($subject1);
        $sa2->setStudent($student2);

        $manager->persist($sa2);

        $sa3 = new StudentAssessment();
        $sa3->setWorkloadExercises(20);
        $sa3->setWorkloadLectures(30);
        $sa3->setAssessment(2);
        $sa3->setSubject($subject1);
        $sa3->setStudent($student3);

        $manager->persist($sa3);

        $sa4 = new StudentAssessment();
        $sa4->setWorkloadExercises(20);
        $sa4->setWorkloadLectures(30);
        $sa4->setAssessment(2);
        $sa4->setSubject($subject1);
        $sa4->setStudent($student4);

        $manager->persist($sa4);

        $sa5 = new StudentAssessment();
        $sa5->setWorkloadExercises(20);
        $sa5->setWorkloadLectures(30);
        $sa5->setAssessment(3);
        $sa5->setSubject($subject4);
        $sa5->setStudent($student5);

        $manager->persist($sa5);

        $sa6 = new StudentAssessment();
        $sa6->setWorkloadExercises(40);
        $sa6->setWorkloadLectures(30);
        $sa6->setAssessment(5);
        $sa6->setSubject($subject6);
        $sa6->setStudent($student7);

        $manager->persist($sa6);

        $sa7 = new StudentAssessment();
        $sa7->setWorkloadExercises(40);
        $sa7->setWorkloadLectures(20);
        $sa7->setAssessment(6);
        $sa7->setSubject($subject6);
        $sa7->setStudent($student7);

        $manager->persist($sa7);

        $manager->flush();
    }
}