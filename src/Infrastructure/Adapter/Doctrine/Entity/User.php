<?php

namespace App\Infrastructure\Adapter\Doctrine\Entity;

use App\Infrastructure\Adapter\Doctrine\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV6Generator;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV6Generator::class)
     */
    private ?UuidV6Generator $id;

    /**
     * @ORM\Column(type="string", nullable=false, length=255, unique=true)
     */
    private ?string $pseudo;

    /**
     * @ORM\Column(type="string", nullable=false, length=255, unique=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    private ?string $firstname;


    /**
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    private ?string $lastname;

    /**
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    private ?string $password;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="date_immutable")
     */
    protected \DateTimeInterface $registerAt;


    public function __construct()
    {
        $this->registerAt = new \DateTimeImmutable();
    }

    public function getId(): ?UuidV6Generator
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRegisterAt(): ?\DateTimeImmutable
    {
        return $this->registerAt;
    }
}
