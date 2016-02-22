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
use AppBundle\Entity\Course;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCoursetData implements FixtureInterface, ContainerAwareInterface
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
        $course = new Course();
        $course->setName('Първи');

        $manager->persist($course);
        $manager->flush();

        $course = new Course();
        $course->setName('Втори');

        $manager->persist($course);
        $manager->flush();

        $course = new Course();
        $course->setName('Трети');

        $manager->persist($course);
        $manager->flush();

        $course = new Course();
        $course->setName('Четвърти');

        $manager->persist($course);
        $manager->flush();
    }
}