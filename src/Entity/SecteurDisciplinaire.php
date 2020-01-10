<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SecteurDisciplinaireRepository")
 */
class SecteurDisciplinaire
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
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Scrutin", mappedBy="secteurs")
     */
    private $scrutins;

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

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function __construct()
    {
        $this->setActif(true);
        $this->scrutins = new ArrayCollection();
    }

    /**
     * @return Collection|Scrutin[]
     */
    public function getScrutins(): Collection
    {
        return $this->scrutins;
    }

    public function addScrutin(Scrutin $scrutin): self
    {
        if (!$this->scrutins->contains($scrutin)) {
            $this->scrutins[] = $scrutin;
            $scrutin->addSecteur($this);
        }

        return $this;
    }

    public function removeScrutin(Scrutin $scrutin): self
    {
        if ($this->scrutins->contains($scrutin)) {
            $this->scrutins->removeElement($scrutin);
            $scrutin->removeSecteur($this);
        }

        return $this;
    }
}
