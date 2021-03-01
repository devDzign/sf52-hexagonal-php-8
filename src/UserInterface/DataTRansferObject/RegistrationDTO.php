<?php

namespace App\UserInterface\DataTRansferObject;

class RegistrationDTO
{
    private ?string $firstname;
    private ?string $lastname;
    private ?string $email;
    private ?string $pseudo;
    private ?string $plainPassword;

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     *
     * @return RegistrationDTO
     */
    public function setFirstname(?string $firstname): RegistrationDTO
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     *
     * @return RegistrationDTO
     */
    public function setLastname(?string $lastname): RegistrationDTO
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     *
     * @return RegistrationDTO
     */
    public function setEmail(?string $email): RegistrationDTO
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    /**
     * @param string|null $pseudo
     *
     * @return RegistrationDTO
     */
    public function setPseudo(?string $pseudo): RegistrationDTO
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     *
     * @return RegistrationDTO
     */
    public function setPlainPassword(?string $plainPassword): RegistrationDTO
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
