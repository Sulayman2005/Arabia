<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $prix = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateAjout = null;

    #[ORM\ManyToOne(inversedBy: 'no')]
    private ?Categorie $catgeorie = null;

    /**
     * @var Collection<int, Concerne>
     */
    #[ORM\OneToMany(targetEntity: Concerne::class, mappedBy: 'produit')]
    private Collection $concernes;

    public function __construct()
    {
        $this->concernes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDateAjout(): ?\DateTime
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTime $dateAjout): static
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getCatgeorie(): ?Categorie
    {
        return $this->catgeorie;
    }

    public function setCatgeorie(?Categorie $catgeorie): static
    {
        $this->catgeorie = $catgeorie;

        return $this;
    }

    /**
     * @return Collection<int, Concerne>
     */
    public function getConcernes(): Collection
    {
        return $this->concernes;
    }

    public function addConcerne(Concerne $concerne): static
    {
        if (!$this->concernes->contains($concerne)) {
            $this->concernes->add($concerne);
            $concerne->setProduit($this);
        }

        return $this;
    }

    public function removeConcerne(Concerne $concerne): static
    {
        if ($this->concernes->removeElement($concerne)) {
            // set the owning side to null (unless already changed)
            if ($concerne->getProduit() === $this) {
                $concerne->setProduit(null);
            }
        }

        return $this;
    }
}
