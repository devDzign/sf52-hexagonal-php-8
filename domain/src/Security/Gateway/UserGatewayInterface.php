<?php

namespace Domain\Security\Gateway;

use Domain\Security\Model\User;

/**
 * Interface UserGatewayInterface
 * @package Domain\Security\Gateway
 */
interface UserGatewayInterface
{
    /**
     * @param string $email
     *
     * @return bool
     */
    public function isEmailUnique(string $email): bool;

    /**
     * @param string $pseudo
     *
     * @return bool
     */
    public function isPseudoUnique(?string $pseudo): bool;

    /**
     * @param User $user
     */
    public function register(User $user): void;

    /**
     * @param string $email
     * @return User|null
     */
    public function getUserByMail(string $email): ?User;
}
