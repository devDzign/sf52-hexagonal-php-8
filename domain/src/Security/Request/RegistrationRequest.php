<?php

namespace Domain\Security\Request;

use Domain\Security\Assertion\Assertion;
use Domain\Security\Gateway\UserGatewayInterface;

/**
 * Class RegistrationRequest
 * @package Domain\Security\Request
 */
class RegistrationRequest
{
    private ?string $pseudo;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $email;
    private ?string $plainPassword;

    /**
     * @param string|null $pseudo
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $email
     * @param string|null $plainPassword
     *
     * @return static
     */
    public static function create(
        ?string $pseudo,
        ?string $firstName,
        ?string $lastName,
        ?string $email,
        ?string $plainPassword
    ): self {
        return new self($pseudo, $firstName, $lastName, $email, $plainPassword);
    }

    /**
     * RegistrationRequest constructor.
     *
     * @param string|null $pseudo
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $email
     * @param string|null $plainPassword
     */
    private function __construct(
        ?string $pseudo,
        ?string $firstName,
        ?string $lastName,
        ?string $email,
        ?string $plainPassword
    ) {
        $this->pseudo        = $pseudo;
        $this->firstName     = $firstName;
        $this->lastName      = $lastName;
        $this->email         = $email;
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }


    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @return string|null
     */
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    /**
     * @param UserGatewayInterface $userGateway
     *
     */
    public function validate(UserGatewayInterface $userGateway): void
    {
        Assertion::notBlank($this->pseudo);
        Assertion::notBlank($this->firstName);
        Assertion::notBlank($this->lastName);
        Assertion::notBlank($this->email);
        Assertion::email($this->email);
        Assertion::nonUniqueEmail($this->email, $userGateway);
        Assertion::notBlank($this->plainPassword);
        Assertion::minLength($this->plainPassword, 8);
    }
}
