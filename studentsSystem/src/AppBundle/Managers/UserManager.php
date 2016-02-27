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

    public function getUsers($start, $end, $filters = [], $getCount = false){

        $em = $this->entityManager;

        $parameters = [];

        if(!$getCount) {
            $queryString = "SELECT u
                  FROM AppBundle:User u";
        }
        else {
            $queryString = "SELECT count(u.id)
                  FROM AppBundle:User u";
        }

        $queryString .= " WHERE 1=1";

        if(isset($filters['username']) && $filters['username']) {
            $queryString .= " AND s.username LIKE :username";
            $parameters['username'] = $filters['username'];
        }

        if(isset($filters['email']) && $filters['email']) {
            $queryString .= " AND s.email LIKE :email";
            $parameters['email'] = $filters['email'];
        }

        $query = $em->createQuery($queryString)
            ->setParameters($parameters);

        if(!$getCount) {
            $query->setFirstResult($start)
                ->setMaxResults($end);
        }

        $user = $getCount ? $query->getSingleScalarResult() : $query->getResult();

        return $user;
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

    /**
     * @param $id
     * @return User|null|object
     */
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
     * @param $roleName
     * @return \AppBundle\Entity\Role[]
     */
    public function getAdminRole($roleName) {
        $role = $this->entityManager->getRepository("AppBundle:Role")->findOneBy([
                'role' => $roleName
            ]
        );

        return $role;
    }

    /**
     * @param $roleName
     * @return \AppBundle\Entity\Role[]
     */
    public function getTeacherRole($roleName) {
        $role = $this->entityManager->getRepository("AppBundle:Role")->findOneBy([
                'role' => $roleName
            ]
        );

        return $role;
    }

    /**
     * @param $id
     * @return \AppBundle\Entity\Role|null|object
     */
    public function getRoleById($id) {
        $role = $this->entityManager->getRepository("AppBundle:Role")->find($id);

        return $role;
    }

    /**
     * @return \AppBundle\Entity\Role[]|array
     */
    public function getRoles() {
        $roles = $this->entityManager->getRepository("AppBundle:Role")->findAll();

        return $roles;
    }

    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }
}