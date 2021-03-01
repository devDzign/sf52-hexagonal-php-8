<?php

namespace App\Infrastructure\Validator;

use Domain\Security\Gateway\UserGatewayInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NonUniqueEmailValidator extends ConstraintValidator
{

    /**
     * @var UserGatewayInterface
     */
    private UserGatewayInterface $userGateway;

    public function __construct(UserGatewayInterface $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function validate($value, Constraint $constraint)
    {

        if (!$this->userGateway->isEmailUnique($value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
