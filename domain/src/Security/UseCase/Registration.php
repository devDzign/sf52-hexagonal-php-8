<?php

namespace Domain\Security\UseCase;

use Domain\Security\Gateway\UserGatewayInterface;
use Domain\Security\Model\User;
use Domain\Security\Request\RegistrationRequest;
use Domain\Security\Response\RegistrationResponse;
use Domain\Security\Presenter\RegistrationPresenterInterface;

/**
 * Class Registration
 * @package Domain\Security\UseCase
 */
class Registration
{

    /**
     * @var UserGatewayInterface
     */
    private UserGatewayInterface $userGateway;

    public function __construct(UserGatewayInterface $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    /**
     * @param RegistrationRequest $request
     * @param RegistrationPresenterInterface $presenter
     */
    public function execute(RegistrationRequest $request, RegistrationPresenterInterface $presenter): void
    {
        $request->validate($this->userGateway);
        $user = User::createUser($request);
        $this->userGateway->register($user);
        $presenter->present(new RegistrationResponse($user->getEmail()));
    }
}
