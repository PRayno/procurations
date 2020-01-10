<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScrutinRepository")
 */
class Scrutin
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
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Election", inversedBy="scrutins")
     * @ORM\JoinColumn(nullable=false)
     */
    private $election;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Procuration", mappedBy="scrutin", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $procurations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\College", inversedBy="scrutins")
     */
    private $colleges;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SecteurDisciplinaire", inversedBy="scrutins")
     */
    private $secteurs;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $explications;

    public function __construct()
    {
        $this->procurations = new ArrayCollection();
        $this->colleges = new ArrayCollection();
        $this->secteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getElection(): ?Election
    {
        return $this->election;
    }

    public function setElection(?Election $election): self
    {
        $this->election = $election;

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }


    /**
     * @return Collection|Procuration[]
     */
    public function getProcurations(): Collection
    {
        return $this->procurations;
    }

    public function addProcuration(Procuration $procuration): self
    {
        if (!$this->procurations->contains($procuration)) {
            $this->procurations[] = $procuration;
            $procuration->setScrutin($this);
        }

        return $this;
    }

    public function removeProcuration(Procuration $procuration): self
    {
        if ($this->procurations->contains($procuration)) {
            $this->procurations->removeElement($procuration);
            // set the owning side to null (unless already changed)
            if ($procuration->getScrutin() === $this) {
                $procuration->setScrutin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|College[]
     */
    public function getColleges(): Collection
    {
        return $this->colleges;
    }

    public function addCollege(College $college): self
    {
        if (!$this->colleges->contains($college)) {
            $this->colleges[] = $college;
        }

        return $this;
    }

    public function removeCollege(College $college): self
    {
        if ($this->colleges->contains($college)) {
            $this->colleges->removeElement($college);
        }

        return $this;
    }

    /**
     * @return Collection|SecteurDisciplinaire[]
     */
    public function getSecteurs(): Collection
    {
        return $this->secteurs;
    }

    public function addSecteur(SecteurDisciplinaire $secteur): self
    {
        if (!$this->secteurs->contains($secteur)) {
            $this->secteurs[] = $secteur;
        }

        return $this;
    }

    public function removeSecteur(SecteurDisciplinaire $secteur): self
    {
        if ($this->secteurs->contains($secteur)) {
            $this->secteurs->removeElement($secteur);
        }

        return $this;
    }

    public function getExplications(): ?string
    {
        return $this->explications;
    }

    public function setExplications(?string $explications): self
    {
        $this->explications = $explications;

        return $this;
    }

}
