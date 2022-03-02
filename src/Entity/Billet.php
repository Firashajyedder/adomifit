<?php

namespace App\Entity;

use App\Repository\BilletRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BilletRepository::class)
 */
class Billet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank (message="Veuillez remplir ce champs")
     
     */
    private $detail;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank (message="Veuillez remplir ce champs")
     * @Assert\Range( min = "now")
     */
    private $horaire;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="billets")
     * @Assert\NotBlank (message="Veuillez remplir ce champs")
     */
    private $evenement;

    
    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\NotBlank (message="Veuillez remplir ce champs")
     */
    private $numero;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank (message="Veuillez remplir ce champs")
     */
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?float
    {
        return $this->numero;
    }

    public function setNumero(float $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    public function getHoraire(): ?\DateTimeInterface
    {
        return $this->horaire;
    }

    public function setHoraire(?\DateTimeInterface $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    
}
