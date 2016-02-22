<?php
///**
// * Created by PhpStorm.
// * User: dahaka
// * Date: 2/22/16
// * Time: 10:38 PM
// */
//
//namespace AppBundle\DataFixtures\ORM;
//
//use Doctrine\Common\DataFixtures\FixtureInterface;
//use Doctrine\Common\Persistence\ObjectManager;
//use AppBundle\Entity\Course;
//use Symfony\Component\DependencyInjection\ContainerAwareInterface;
//use Symfony\Component\DependencyInjection\ContainerInterface;
//
//class LoadCourseData implements FixtureInterface, ContainerAwareInterface
//{
//    /**
//     * @var ContainerInterface
//     */
//    private $container;
//
//    public function setContainer(ContainerInterface $container = null)
//    {
//        $this->container = $container;
//    }
//
//    public function load(ObjectManager $manager)
//    {
//        $course1 = new Course();
//        $course1->setName('Първи');
//
//        $manager->persist($course1);
//
//        $course2 = new Course();
//        $course2->setName('Втори');
//
//        $manager->persist($course2);
//
//        $course3 = new Course();
//        $course3->setName('Трети');
//
//        $manager->persist($course3);
//
//        $course4 = new Course();
//        $course4->setName('Четвърти');
//
//        $manager->persist($course4);
//
//        $manager->flush();
//    }
//}