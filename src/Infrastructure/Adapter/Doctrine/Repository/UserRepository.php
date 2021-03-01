<?php

namespace App\Infrastructure\Adapter\Doctrine\Repository;

use App\Infrastructure\Adapter\Doctrine\Entity\User;
use Domain\Security\Gateway\UserGatewayInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserGatewayInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function isPseudoUnique(?string $pseudo): bool
    {
        return $this->count(["pseudo" => $pseudo]) === 0;
    }

    public function register(\Domain\Security\Model\User $user): void
    {
        $userRegistration = new User();
        $this->_em->persist($userRegistration);
        $this->_em->flush();
    }

    /**
     * @param string|null $email
     *
     * @return bool
     */
    public function isEmailUnique(?string $email): bool
    {
        return $this->count(["email" => $email]) === 0;
    }

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getUserByMail(string $email): ?\Domain\Security\Model\User
    {
        /** @var User $doctrineUser */
        $doctrineUser =  $this->findOneByEmail($email);

        if (!$doctrineUser) {
            return null;
        }

        /** @var \Domain\Security\Model\User $doctrineUser */
        return new User(
            $doctrineUser->getId(),
            $doctrineUser->getId(),
            $doctrineUser->getFirstName(),
            $doctrineUser->getLastName(),
            $doctrineUser->getEmail(),
            $doctrineUser->getPassword(),
        );
    }
}
