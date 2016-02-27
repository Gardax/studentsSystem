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
//use AppBundle\Entity\Subject;
//use Symfony\Component\DependencyInjection\ContainerAwareInterface;
//use Symfony\Component\DependencyInjection\ContainerInterface;
//
//class LoadSubjectData implements FixtureInterface, ContainerAwareInterface
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
//        $subject2 = new Subject();
//        $subject2->setName('Линейна алгебра и аналитична геометрия');
//        $subject2->setWorkloadLectures('60');
//        $subject2->setWorkloadExercises('60');
//
//        $manager->persist($subject2);
//
//        $subject3 = new Subject();
//        $subject3->setName('Увод в информационните технологии');
//        $subject3->setWorkloadLectures('40');
//        $subject3->setWorkloadExercises('60');
//
//        $manager->persist($subject3);
//
//        $subject4 = new Subject();
//        $subject4->setName('Английски език');
//        $subject4->setWorkloadLectures('30');
//        $subject4->setWorkloadExercises('30');
//
//        $manager->persist($subject4);
//
//        $subject5 = new Subject();
//        $subject5->setName('Създаване на ГПИ (С#)');
//        $subject5->setWorkloadLectures('40');
//        $subject5->setWorkloadExercises('60');
//
//        $manager->persist($subject5);
//
//        $subject6 = new Subject();
//        $subject6->setName('Основи на графичния дизайн');
//        $subject6->setWorkloadLectures('40');
//        $subject6->setWorkloadExercises('60');
//
//        $manager->persist($subject6);
//
//        $subject7 = new Subject();
//        $subject7->setName('Софтуерни системи по математика');
//        $subject7->setWorkloadLectures('40');
//        $subject7->setWorkloadExercises('60');
//
//        $manager->persist($subject7);
//
//        $subject8 = new Subject();
//        $subject8->setName('Спорт');
//        $subject8->setWorkloadLectures('40');
//        $subject8->setWorkloadExercises('60');
//
//        $manager->persist($subject8);
//
//
//        $manager->flush();
//    }
//}