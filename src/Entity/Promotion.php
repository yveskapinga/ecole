<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PromotionRepository")
 */
class Promotion
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
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etudiant", mappedBy="promotion")
     */
    private $etudiant;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cour", mappedBy="promotion")
     */
    private $cour;

    public function __construct()
    {
        $this->etudiant = new ArrayCollection();
        $this->cour = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiant(): Collection
    {
        return $this->etudiant;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiant->contains($etudiant)) {
            $this->etudiant[] = $etudiant;
            $etudiant->setPromotion($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiant->contains($etudiant)) {
            $this->etudiant->removeElement($etudiant);
            // set the owning side to null (unless already changed)
            if ($etudiant->getPromotion() === $this) {
                $etudiant->setPromotion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cour[]
     */
    public function getCour(): Collection
    {
        return $this->cour;
    }

    public function addCour(Cour $cour): self
    {
        if (!$this->cour->contains($cour)) {
            $this->cour[] = $cour;
            $cour->setPromotion($this);
        }

        return $this;
    }

    public function removeCour(Cour $cour): self
    {
        if ($this->cour->contains($cour)) {
            $this->cour->removeElement($cour);
            // set the owning side to null (unless already changed)
            if ($cour->getPromotion() === $this) {
                $cour->setPromotion(null);
            }
        }

        return $this;
    }
}
