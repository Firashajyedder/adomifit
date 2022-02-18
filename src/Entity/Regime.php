<?php

namespace App\Entity;

use App\Repository\RegimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegimeRepository::class)
 */
class Regime
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dificulte;

    

    /**
     * @ORM\OneToMany(targetEntity=SuiviRegime::class, mappedBy="regime")
     */
    private $suivisRegimes;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieRegime::class, inversedBy="regimes")
     */
    private $categorieRegime;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="regimes")
     */
    private $user;

    public function __construct()
    {
        $this->suivisRegimes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getDificulte(): ?string
    {
        return $this->dificulte;
    }

    public function setDificulte(?string $dificulte): self
    {
        $this->dificulte = $dificulte;

        return $this;
    }


    /**
     * @return Collection|suiviRegime[]
     */
    public function getSuivisRegimes(): Collection
    {
        return $this->suivisRegimes;
    }

    public function addSuivisRegime(suiviRegime $suivisRegime): self
    {
        if (!$this->suivisRegimes->contains($suivisRegime)) {
            $this->suivisRegimes[] = $suivisRegime;
            $suivisRegime->setRegime($this);
        }

        return $this;
    }

    public function removeSuivisRegime(suiviRegime $suivisRegime): self
    {
        if ($this->suivisRegimes->removeElement($suivisRegime)) {
            // set the owning side to null (unless already changed)
            if ($suivisRegime->getRegime() === $this) {
                $suivisRegime->setRegime(null);
            }
        }

        return $this;
    }

    public function getCategorieRegime(): ?CategorieRegime
    {
        return $this->categorieRegime;
    }

    public function setCategorieRegime(?CategorieRegime $categorieRegime): self
    {
        $this->categorieRegime = $categorieRegime;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
