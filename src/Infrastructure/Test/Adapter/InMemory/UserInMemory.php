<?php

namespace App\Infrastructure\Test\Adapter\InMemory;

use Domain\Security\Gateway\UserGatewayInterface;
use Domain\Security\Model\User;
use Symfony\Component\Uid\Uuid;

class UserInMemory implements UserGatewayInterface
{

    /**
     * @inheritDoc
     */
    public function isEmailUnique(?string $email): bool
    {
        return !in_array($email, ["used@email.com"]);
    }


    public function getUserByMail(string $email): ?User
    {

        if ($email !== "new_used@email.com") {
            return null;
        }

        return new User(
            Uuid::v6(),
            'new_user',
            'mourad',
            'chabour',
            'new_used',
            password_hash("password", PASSWORD_ARGON2I)
        );
    }

    public function isPseudoUnique(?string $pseudo): bool
    {
        return !in_array($pseudo, ["used"]);
    }

    public function register(User $user): void
    {
        // TODO: Implement register() method.
    }
}
