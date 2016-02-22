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
//use AppBundle\Entity\Speciality;
//use Symfony\Component\DependencyInjection\ContainerAwareInterface;
//use Symfony\Component\DependencyInjection\ContainerInterface;
//
//class LoadSpecialityData implements FixtureInterface, ContainerAwareInterface
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
//        $speciality1 = new Speciality();
//        $speciality1->setSpecialityLongName('Математика и Информатика');
//        $speciality1->setSpecialityShortName('МИ');
//
//        $manager->persist($speciality1);
//
//        $speciality2 = new Speciality();
//        $speciality2->setSpecialityLongName('Софтуерни технологии и дизайн');
//        $speciality2->setSpecialityShortName('СТД');
//
//        $manager->persist($speciality2);
//
//        $speciality3 = new Speciality();
//        $speciality3->setSpecialityLongName('Бизнес информационни технологии');
//        $speciality3->setSpecialityShortName('БИТ');
//
//        $manager->persist($speciality3);
//
//        $speciality4 = new Speciality();
//        $speciality4->setSpecialityLongName('Информатика');
//        $speciality4->setSpecialityShortName('И');
//
//        $manager->persist($speciality4);
//
//        $speciality5 = new Speciality();
//        $speciality5->setSpecialityLongName('Математика');
//        $speciality5->setSpecialityShortName('М');
//
//        $manager->persist($speciality5);
//
//        $speciality6 = new Speciality();
//        $speciality6->setSpecialityLongName('Информационни технологии, математика и образователен мениджмънт ');
//        $speciality6->setSpecialityShortName('ИТМОМ');
//
//        $manager->persist($speciality5);
//
//        $speciality7 = new Speciality();
//        $speciality7->setSpecialityLongName('Бизнес математика');
//        $speciality7->setSpecialityShortName('БМ');
//
//        $manager->persist($speciality7);
//
//        $speciality8 = new Speciality();
//        $speciality8->setSpecialityLongName('Приложна математика');
//        $speciality8->setSpecialityShortName('ПМ');
//
//        $manager->persist($speciality8);
//
//
//        $manager->flush();
//    }
//}