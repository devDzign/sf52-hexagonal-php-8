<?php

namespace Domain\Tests\Security;

use Assert\AssertionFailedException;
use Domain\Security\Gateway\UserGatewayInterface;
use Domain\Security\Model\User;
use Domain\Security\Presenter\RegistrationPresenterInterface;
use Domain\Security\Request\RegistrationRequest;
use Domain\Security\Response\RegistrationResponse;
use Domain\Security\UseCase\Registration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * Class RegistrationTest
 * @package Domain\Tests\Security
 */
class RegistrationTest extends TestCase
{

    /**
     * @var Registration
     */
    private Registration $useCase;

    /**
     * @var RegistrationPresenterInterface
     */
    private RegistrationPresenterInterface $presenter;



    protected function setUp(): void
    {
        $this->presenter = new class () implements RegistrationPresenterInterface {
            public RegistrationResponse $response;

            public function present(RegistrationResponse $response): void
            {
                $this->response = $response;
            }
        };

        $userGateway = new class () implements UserGatewayInterface {

            public function isEmailUnique(string $email): bool
            {
                return !in_array($email, ['usedEmail@email.com', 'used_mail@email.fr']);
            }

            /**
             * @param User $user
             */
            public function register(User $user): void
            {
            }

            public function getUserByMail(string $email): ?User
            {

                if ($email !== "user@email.com") {
                    return null;
                }

                return new User(
                    Uuid::v6(),
                    'user',
                    'mourad',
                    'chabour',
                    'user@email.com',
                    'password'
                );
            }

            public function isPseudoUnique(string $pseudo): bool
            {
                return !in_array($pseudo, ['usedPseudo', 'used_pseudo']);
            }
        };

        $this->useCase = new Registration($userGateway);
    }

    public function testSuccessFull(): void
    {
        $request = RegistrationRequest::create(
            'user',
            'mourad',
            'chabour',
            'user@email.com',
            'password'
        );

        $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(RegistrationResponse::class, $this->presenter->response);
        $this->assertEquals('user@email.com', $this->presenter->response->getEmail());
    }

    /**
     * @dataProvider provideRequestData
     *
     * @param string $pseudo
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $plaiPassword
     */
    public function testFailed(
        string $pseudo,
        string $firstName,
        string $lastName,
        string $email,
        string $plaiPassword
    ): void {

        $request = RegistrationRequest::create(
            $pseudo,
            $firstName,
            $lastName,
            $email,
            $plaiPassword
        );


        $this->expectException(AssertionFailedException::class);
        $this->useCase->execute($request, $this->presenter);
    }

    public function provideRequestData(): \Generator
    {
        yield ["user","", "chabour", "mchabour@codechallenge.fr", "password"];
        yield ["user","mourad", "", "mchabour@codechallenge.fr", "password"];

        // case password failed
        yield ["user","mourad", "chabour","mchabour@codechallenge.fr", ""];

        // case short password < 8
        yield ["user","mourad", "chabour", "mchabour@codechallenge.fr", "faild"];

        // case of pseudo failed
        yield ["","mourad", "chabour", "mchabour@codechallenge.fr", "password"];
        yield ["usedPseudo","mourad", "chabour", "mchabour@codechallenge.fr", "password"];

        // case of mail failed
        yield ["user","mourad", "chabour", "", "password"];
        yield ["user","mourad", "chabour", "mchabour", "password"];
        yield ["user","mourad", "chabour", "fail", "password"];
        yield ["user","mourad", "chabour", "usedEmail@email.com", "password"];
    }
}
