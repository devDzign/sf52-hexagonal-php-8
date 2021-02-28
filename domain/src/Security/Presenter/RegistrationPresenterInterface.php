<?php

namespace Domain\Security\Presenter;

use Domain\Security\Response\RegistrationResponse;

/**
 * Interface RegistrationPresenterInterface
 * @package Domain\Security\Presenter
 */
interface RegistrationPresenterInterface
{

    /**
     * @param RegistrationResponse $response
     */
    public function present(RegistrationResponse $response): void;
}
