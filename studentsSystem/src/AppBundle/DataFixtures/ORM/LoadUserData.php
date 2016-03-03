<?php

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
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
        $user = new User();
        $user->setUsername('admin');
        $user->setUserFirstName('stamat');
        $user->setUserLastName('stamativan');
        $user->setEmail('admin@test.com');
        $user->setApiKey('');

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'faster');
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();


        $user2 = new User();
        $user2->setUsername('suxorr');
        $user2->setUserFirstName('mario');
        $user2->setUserLastName('hristev');
        $user2->setEmail('hristevmario@gmail.com');
        $user2->setApiKey('a');

        $encoder2 = $this->container->get('security.password_encoder');
        $password2 = $encoder2->encodePassword($user2, 'azsammario123');
        $user2->setPassword($password2);
        $manager->persist($user2);
        $manager->flush();

        $roleAdmin = new Role();
        $roleAdmin->setRole('ROLE_ADMIN');
        $roleAdmin->addUser($user);
        $manager->persist($roleAdmin);

        $roleTeacher = new Role();
        $roleTeacher->setRole('ROLE_TEACHER');
        $roleTeacher->addUser($user);
        $manager->persist($roleTeacher);

        $roleUser = new Role();
        $roleUser->setRole('ROLE_USER');
        $roleUser->addUser($user);
        $manager->persist($roleUser);

        $roleAdmin2 = new Role();
        $roleAdmin2->addUser($user2);
        $manager->persist($roleAdmin);

        $roleTeacher2 = new Role();
        $roleTeacher2->addUser($user2);
        $manager->persist($roleTeacher);

        $roleUser2 = new Role();
        $roleUser2->addUser($user2);
        $manager->persist($roleUser);


        $user->addRole($roleAdmin);
        $user->addRole($roleTeacher);
        $user->addRole($roleUser);

        $user2->addRole($roleAdmin);
        $user2->addRole($roleTeacher);
        $user2->addRole($roleUser);

        $manager->flush();
    }
}