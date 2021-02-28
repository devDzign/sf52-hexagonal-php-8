<?php

namespace Domain\Security\Assertion;

use Assert\Assert;
use Domain\Security\Exception\NonUniquePseudoException;
use Domain\Security\Gateway\UserGatewayInterface;

class UniquePseudoAssertion extends Assert
{

    public const EXISTING_PSEUDO = 501;

    /**
     * @param string               $pseudo
     * @param UserGatewayInterface $userGateway
     *
     * @throws NonUniquePseudoException
     */
    public static function nonUniquePseudo(string $pseudo, UserGatewayInterface $userGateway): void
    {
        if (!$userGateway->isPseudoUnique($pseudo)) {
            throw new NonUniquePseudoException('This pseudo should be unique', self::EXISTING_PSEUDO);
        }
    }
}
