<?php

namespace App\Entity;
use App\Entity\Personne;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonneRepository")
 */
class Enseignant extends Personne
{
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Enseigne", mappedBy="enseignant")
     */
    private $enseignant;

    public function __construct()
    {
        parent::__construct();
        $this->enseignant = new ArrayCollection();
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