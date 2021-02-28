<?php

namespace Domain\Security\Assertion;

use Assert\Assertion as BaseAssertion;
use Domain\Security\Exception\NonUniqueEmailException;
use Domain\Security\Gateway\UserGatewayInterface;

class Assertion extends BaseAssertion
{
    public const EXISTING_EMAIL = 500;
    public const EXISTING_PSEUDO = 501;

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
