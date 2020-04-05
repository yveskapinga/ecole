<?php

namespace App\Entity;
use App\Entity\Personne;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtudiantRepository")
 */
class Etudiant extends Personne{

     /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDeNaissance;

    /**
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Votre mot de passe doit être au moins {{ limit }} characters long",
     *      allowEmptyString = false
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Absence", mappedBy="etudiant")
     */
    private $absences;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion", inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $promotion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inscrit=false;

    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }
    public function setDateDeNaissance(\Datetime $dateDeNaissance = null)
    {
        $this->dateDeNaissance = $dateDeNaissance;

    }
    
    public function __construct()
    {
        $this->absences = new ArrayCollection();
        $this->adresses = new ArrayCollection();
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        
        return $this;
    }

    /**
     * @return Collection|Absence[]
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absence $absence): self
    {
        if (!$this->absences->contains($absence)) {
            $this->absences[] = $absence;
            $absence->setEtudiant($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->contains($absence)) {
            $this->absences->removeElement($absence);
            // set the owning side to null (unless already changed)
            if ($absence->getEtudiant() === $this) {
                $absence->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getInscrit(): ?bool
    {
        return $this->inscrit;
    }

    public function setInscrit(bool $inscrit): self
    {
        $this->inscrit = $inscrit;

        return $this;
    }  
}