<?php

namespace AppBundle\Managers;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

/**
 * Class UserManager
 * @package AppBundle\Managers
 */
class UserManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em) {
        $this->entityManager=$em;
    }

    /**
     * @param User $userEntity
     * @return User
     */
    public function addUser(User $userEntity){
        $this->entityManager->persist($userEntity);
        $this->entityManager->flush();

        return $userEntity;
    }


    public function getUserById($id)
    {
        $user = $this->entityManager->getRepository("AppBundle:User")->find($id);

        return $user;
    }

    /**
     * @param $apiKey
     * @return User
     */
    public function getUserByApiKey($apiKey)
    {
        $query = $this->entityManager->createQuery(
            "SELECT u
             FROM AppBundle:User u
             WHERE u.apiKey LIKE :apikey"
        )
            ->setParameters([
                "apikey" => $apiKey
            ]);


        $user = $query->getOneOrNullResult();

        return $user;
    }

    /**
     * @param $username
     * @return User
     */
    public function getUserByUsername($username)
    {
        $query = $this->entityManager->createQuery(
            "SELECT u
             FROM AppBundle:User u
             WHERE u.username = :username"
        )
            ->setParameters([
                "username" => $username
            ]);

        $user = $query->getOneOrNullResult();

        return $user;
    }

    /**
     * @param $uniqueIdentifier
     * @return User | null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserByUserNameOrEmail($uniqueIdentifier){
        $query = $this->entityManager->createQuery(
            "SELECT u
             FROM AppBundle:User u
             WHERE u.username = :uniqueIdentifier OR u.email = :uniqueIdentifier"
        )
            ->setParameters([
                "uniqueIdentifier" => $uniqueIdentifier
            ]);

        $user = $query->getOneOrNullResult();

        return $user;
    }

    /**
     * Gets user role by role name.
     *
     * @param $roleName
     * @return \AppBundle\Entity\Role[]
     */
    public function getUserRole($roleName) {
        $role = $this->entityManager->getRepository("AppBundle:Role")->findOneBy([
                'role' => $roleName
            ]
        );

        return $role;
    }

    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }
}