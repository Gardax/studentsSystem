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
use AppBundle\Entity\Subject;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadSubjectData implements FixtureInterface, ContainerAwareInterface
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
        $subject = new Subject();
        $subject->setName('Matematika');
        $subject->setWorkloadLectures('40');
        $subject->setWorkloadExercises('60');

        $manager->persist($subject);
        $manager->flush();
    }
}