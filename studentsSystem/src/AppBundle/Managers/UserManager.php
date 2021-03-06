<?php

namespace AppBundle\Managers;

use AppBundle\Entity\User;
use AppBundle\Services\UserService;
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
                  FROM AppBundle:User u ";
        }
        else {
            $queryString = "SELECT count(u.id)
                  FROM AppBundle:User u";
        }

        $queryString .= " WHERE 1=1";

        if(isset($filters['username']) && $filters['username']) {
            $queryString .= " AND u.username LIKE :username";
            $parameters['username'] = $filters['username'] . '%';
        }

        if(isset($filters['email']) && $filters['email']) {
            $queryString .= " AND u.email = :email";
            $parameters['email'] = $filters['email'];
        }

        $query = $em->createQuery($queryString)
            ->setParameters($parameters);

        if(!$getCount && $end) {
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
     * @param $id
     * @return \AppBundle\Entity\Role|null|object
     */
    public function getRoleById($id) {
        $role = $this->entityManager->getRepository("AppBundle:Role")->find($id);

        return $role;
    }

    /**
     * @param boolean $withoutUserRole
     * @return \AppBundle\Entity\Role[]|array
     */
    public function getRoles($withoutUserRole) {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('r')
            ->from('AppBundle:Role', 'r');

        $parameters = [];
        if($withoutUserRole) {
            $qb->where($qb->expr()->neq('r.role', ':roleUser'));
            $parameters['roleUser'] = UserService::ROLE_USER;
        }

        $query = $qb->getQuery();
        $query->setParameters($parameters);

        $roles = $query->getResult();

        return $roles;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function deleteUser(User $user){

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return true;
    }

    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }
}