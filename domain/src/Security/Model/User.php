<?php

namespace Domain\Security\Model;

use Domain\Security\Request\RegistrationRequest;
use Symfony\Component\Uid\Uuid;

class User
{




    private Uuid $id;
    private ?string $pseudo;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $email;
    private ?string $password;
    /**
     * @var string
     */
    private string $plainPassword;

    /**
     * User constructor.
     *
     * @param Uuid        $id
     * @param string|null $pseudo
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $email
     * @param string|null $password
     */
    public function __construct(
        Uuid $id,
        ?string $pseudo,
        ?string $firstName,
        ?string $lastName,
        ?string $email,
        ?string $password
    ) {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @param RegistrationRequest $request
     *
     * @return static
     */
    public static function createUser(RegistrationRequest $request): self
    {
        return new self(
            Uuid::v6(),
            $request->getPseudo(),
            $request->getFirstName(),
            $request->getLastName(),
            $request->getEmail(),
            password_hash($request->getPlainPassword(), PASSWORD_ARGON2I)
        );
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

}
