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

        $roleAdmin = new Role();
        $roleAdmin->setRole('ROLE_ADMIN');
        $roleAdmin->addUser($user);
        $manager->persist($roleAdmin);

        $roleUser = new Role();
        $roleUser->setRole('ROLE_USER');
        $roleUser->addUser($user);
        $manager->persist($roleUser);

        $user->addRole($roleAdmin);
        $user->addRole($roleUser);

        $manager->flush();
    }
}