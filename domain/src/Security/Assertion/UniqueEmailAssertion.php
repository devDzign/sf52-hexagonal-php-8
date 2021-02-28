<?php

namespace Domain\Security\Assertion;

use Assert\Assertion;
use Domain\Security\Exception\NonUniqueEmailException;
use Domain\Security\Gateway\UserGatewayInterface;

class UniqueEmailAssertion extends Assertion
{
    public const EXISTING_EMAIL = 500;

    /**
     * @param string               $email
     * @param UserGatewayInterface $userGateway
     *
     * @throws NonUniqueEmailException
     */
    public static function nonUniqueEmail(string $email, UserGatewayInterface $userGateway): void
    {
        if (!$userGateway->isEmailUnique($email)) {
            throw new NonUniqueEmailException('This email should be unique', self::EXISTING_EMAIL);
        }
    }
}
