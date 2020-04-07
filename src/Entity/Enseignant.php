<?php

namespace App\Entity;
use App\Entity\Personne;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnseignantRepository")
 */
class Enseignant extends Admin
{

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Enseigne", mappedBy="enseignant")
     */
    private $enseignant;

    public function __construct()
    {
        parent::__construct();
        $this->enseignant = new ArrayCollection();
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|Enseigne[]
     */
    public function getEnseignant(): Collection
    {
        return $this->enseignant;
    }

    public function addEnseignant(Enseigne $enseignant): self
    {
        if (!$this->enseignant->contains($enseignant)) {
            $this->enseignant[] = $enseignant;
            $enseignant->addEnseignant($this);
        }

        return $this;
    }

    public function removeEnseignant(Enseigne $enseignant): self
    {
        if ($this->enseignant->contains($enseignant)) {
            $this->enseignant->removeElement($enseignant);
            $enseignant->removeEnseignant($this);
        }

        return $this;
    }
}