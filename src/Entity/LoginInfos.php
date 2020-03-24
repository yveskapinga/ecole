<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoginInfosRepository")
 */
class LoginInfos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motDepasse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $login;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotDepasse(): ?string
    {
        return $this->motDepasse;
    }

    public function setMotDepasse(string $motDepasse): self
    {
        $this->motDepasse = $motDepasse;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }
}
