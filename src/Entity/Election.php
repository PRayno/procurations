<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ElectionRepository")
 */
class Election
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
     * @ORM\Column(type="datetime")
     */
    private $debut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Scrutin", mappedBy="election", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $scrutins;

    public function __construct()
    {
        $this->scrutins = new ArrayCollection();
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

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
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
            $scrutin->setElection($this);
        }

        return $this;
    }

    public function removeScrutin(Scrutin $scrutin): self
    {
        if ($this->scrutins->contains($scrutin)) {
            $this->scrutins->removeElement($scrutin);
            // set the owning side to null (unless already changed)
            if ($scrutin->getElection() === $this) {
                $scrutin->setElection(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }


}
