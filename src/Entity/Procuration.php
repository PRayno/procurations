<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProcurationRepository")
 */
class Procuration
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
    private $username;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Scrutin", inversedBy="procurations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $scrutin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\College")
     * @ORM\JoinColumn(nullable=false)
     */
    private $college;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SecteurDisciplinaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $secteurDisciplinaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mandataire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $printed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getScrutin(): ?Scrutin
    {
        return $this->scrutin;
    }

    public function setScrutin(?Scrutin $scrutin): self
    {
        $this->scrutin = $scrutin;

        return $this;
    }

    public function getCollege(): ?College
    {
        return $this->college;
    }

    public function setCollege(?College $college): self
    {
        $this->college = $college;

        return $this;
    }

    public function getSecteurDisciplinaire(): ?SecteurDisciplinaire
    {
        return $this->secteurDisciplinaire;
    }

    public function setSecteurDisciplinaire(?SecteurDisciplinaire $secteurDisciplinaire): self
    {
        $this->secteurDisciplinaire = $secteurDisciplinaire;

        return $this;
    }

    public function getMandataire(): ?string
    {
        return $this->mandataire;
    }

    public function setMandataire(string $mandataire): self
    {
        $this->mandataire = $mandataire;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNumber()
    {
        return str_repeat("0", (5-strlen($this->id))).$this->id;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPrinted(): ?bool
    {
        return $this->printed;
    }

    public function setPrinted(bool $printed): self
    {
        $this->printed = $printed;

        return $this;
    }
}
