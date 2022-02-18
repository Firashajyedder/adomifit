<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgrammeRepository::class)
 */
class Programme
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $affiche;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $difficulte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duree;

    
    /**
     * @ORM\OneToMany(targetEntity=SuiviProgramme::class, mappedBy="programme")
     */
    private $suivisProgrammes;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieProgramme::class, inversedBy="programmes")
     */
    private $categorieProgramme;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="programmes")
     */
    private $user;

    public function __construct()
    {
        $this->suivisProgrammes = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAffiche(): ?string
    {
        return $this->affiche;
    }

    public function setAffiche(?string $affiche): self
    {
        $this->affiche = $affiche;

        return $this;
    }

    public function getDifficulte(): ?string
    {
        return $this->difficulte;
    }

    public function setDifficulte(?string $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

   

    /**
     * @return Collection|suiviProgramme[]
     */
    public function getSuivisProgrammes(): Collection
    {
        return $this->suivisProgrammes;
    }

    public function addSuivisProgramme(suiviProgramme $suivisProgramme): self
    {
        if (!$this->suivisProgrammes->contains($suivisProgramme)) {
            $this->suivisProgrammes[] = $suivisProgramme;
            $suivisProgramme->setProgramme($this);
        }

        return $this;
    }

    public function removeSuivisProgramme(suiviProgramme $suivisProgramme): self
    {
        if ($this->suivisProgrammes->removeElement($suivisProgramme)) {
            // set the owning side to null (unless already changed)
            if ($suivisProgramme->getProgramme() === $this) {
                $suivisProgramme->setProgramme(null);
            }
        }

        return $this;
    }

    public function getCategorieProgramme(): ?CategorieProgramme
    {
        return $this->categorieProgramme;
    }

    public function setCategorieProgramme(?CategorieProgramme $categorieProgramme): self
    {
        $this->categorieProgramme = $categorieProgramme;

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
