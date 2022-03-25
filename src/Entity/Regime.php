<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RegimeRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RegimeRepository::class)
 */
class Regime
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("regime")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="donner type de régime !")
     *  * @Assert\Length(
     *      min = 10,
     *      max = 30,
     *      minMessage = "Minimum {{ limit }} caractéres",
     *      maxMessage = "Maximum {{ limit }} caractéres"
     * )
     * @Groups("regime")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="donner description de régime !")
     * @Groups("regime")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="donner dificulte de régime !")
     * @Groups("regime")
     */
    private $dificulte;

    

    /**
     * @ORM\OneToMany(targetEntity=SuiviRegime::class, mappedBy="regime")
     *
     */
    private $suivisRegimes;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieRegime::class, inversedBy="regimes")
     * @Assert\NotBlank(message="selectionner catégeorie de régime !")
     * @Groups("cat")
     *
     */
    private $categorieRegime;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="regimes")
     * @Groups("user")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="l'image de régime !")
     * @Groups("regime")
     */
    
    private $image;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups("regime")
     */
    private $createdAt;
    
  

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\NotBlank(message="le prix de régime !")
     * @Assert\Positive(message="le prix doit etre > 0 !")
     * @Groups("regime")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     * @ORM\JoinColumn(name="categorie_regime_id", referencedColumnName="id")
     * @Groups("cat")
     */
    private $categorie_regime_id ;
      /**
     * @ORM\Column(type="integer")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Groups("regime")
     * 
     */
    private $user_id;


    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
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
    public function __toString()
    {
        return(string)$this->getType();
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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }



    public function getCategorieRegimeId(): ?int
    {
        return $this->categorie_regime_id;
    }

    public function setCategorieRegimeId(int $categorie_regime_id): self
    {
        $this->categorie_regime_id = $categorie_regime_id;

        return $this;
    }
    public function getUserId()
    {
        return $this->user_id;
    }

   
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }


   
}
