<?php

namespace AppBundle\Managers;
use AppBundle\Entity\Users;
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
     * @param Users $userEntity
     * @return Users
     */
    public function addUser(Users $userEntity){
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
     * @return Users
     */
    public function getUserByApiKey($apiKey)
    {
        $query = $this->entityManager->createQuery(
            "SELECT u
             FROM AppBundle:Users u
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
     * @return Users
     */
    public function getUserByUsername($username)
    {
        $query = $this->entityManager->createQuery(
            "SELECT u
             FROM AppBundle:Users u
             WHERE u.username LIKE :username"
        )
            ->setParameters([
                "username" => $username
            ]);
        $user = $query->getOneOrNullResult();
        return $user;
    }
    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }
}