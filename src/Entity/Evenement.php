<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Billet::class, mappedBy="evenement")
     */
    private $billets;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieEvenement::class, inversedBy="evenements")
     */
    private $categorieEvenement;

    public function __construct()
    {
        $this->billets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|billet[]
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(billet $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setEvenement($this);
        }

        return $this;
    }

    public function removeBillet(billet $billet): self
    {
        if ($this->billets->removeElement($billet)) {
            // set the owning side to null (unless already changed)
            if ($billet->getEvenement() === $this) {
                $billet->setEvenement(null);
            }
        }

        return $this;
    }

    public function getCategorieEvenement(): ?CategorieEvenement
    {
        return $this->categorieEvenement;
    }

    public function setCategorieEvenement(?CategorieEvenement $categorieEvenement): self
    {
        $this->categorieEvenement = $categorieEvenement;

        return $this;
    }
}
