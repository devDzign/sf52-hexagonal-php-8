<?php

namespace Domain\Security\Response;

use Domain\Security\Model\User;
use stdClass;

/**
 * Class RegistrationResponse
 * @package Domain\Security\Response
 */
class RegistrationResponse
{

    /**
     * RegistrationResponse constructor.
     * @param string $email
     */
    public function __construct(public string $email)
    {
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
