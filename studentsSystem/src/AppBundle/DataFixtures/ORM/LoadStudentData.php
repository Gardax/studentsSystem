<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 2/22/16
 * Time: 10:38 PM
 */

namespace AppBundle\DataFixtures\ORM;

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

        $manager->persist($speciality5);

        $speciality7 = new Speciality();
        $speciality7->setSpecialityLongName('Бизнес математика');
        $speciality7->setSpecialityShortName('БМ');

        $manager->persist($speciality7);

        $speciality8 = new Speciality();
        $speciality8->setSpecialityLongName('Приложна математика');
        $speciality8->setSpecialityShortName('ПМ');

        $manager->persist($speciality8);



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


        $manager->flush();
    }
}