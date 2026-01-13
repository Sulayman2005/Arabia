<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['produit:read']],
    denormalizationContext: ['groups' => ['produit:write']]
)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['produit:read', 'categorie:read', 'commandeProduit:read', 'favori:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['produit:read', 'produit:write', 'categorie:read', 'favori:read'])]
    #[Assert\NotBlank(message: "Le nom du produit est obligatoire.")]
    #[Assert\Length(min: 2, max: 100)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['produit:read', 'produit:write'])]
    #[Assert\NotBlank(message: "La description est obligatoire.")]
    #[Assert\Length(min: 10, minMessage: "La description doit faire au moins {{ limit }} caractères.")]
    private ?string $description = null;

    // Je garde scale: 0 comme chez toi (prix entier). Si tu veux centimes -> scale: 2
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    #[Groups(['produit:read', 'produit:write'])]
    #[Assert\NotBlank(message: "Le prix est obligatoire.")]
    private ?string $prix = null;

    #[ORM\Column]
    #[Groups(['produit:read', 'produit:write'])]
    private ?int $stock = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produit:read', 'produit:write'])]
    #[Assert\NotBlank(message: "L'image est obligatoire.")]
    #[Assert\Length(max: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['produit:read', 'produit:write'])]
    #[Assert\NotNull(message: "La date d'ajout est obligatoire.")]
    private ?\DateTime $dateAjout = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['produit:read', 'produit:write'])]
    private ?Categorie $categorie = null;

    /**
     * @var Collection<int, CommandeProduit>
     */
    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: CommandeProduit::class, orphanRemoval: true)]
    private Collection $commandeProduits;

    /**
     * @var Collection<int, Favori>
     */
    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Favori::class, orphanRemoval: true)]
    private Collection $favoris;

    public function __construct()
    {
        $this->commandeProduits = new ArrayCollection();
        $this->favoris = new ArrayCollection();
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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * @return Collection<int, CommandeProduit>
     */
    public function getCommandeProduits(): Collection
    {
        return $this->commandeProduits;
    }

    public function addCommandeProduit(CommandeProduit $commandeProduit): static
    {
        if (!$this->commandeProduits->contains($commandeProduit)) {
            $this->commandeProduits->add($commandeProduit);
            $commandeProduit->setProduit($this);
        }

        return $this;
    }

    public function removeCommandeProduit(CommandeProduit $commandeProduit): static
    {
        if ($this->commandeProduits->removeElement($commandeProduit)) {
            if ($commandeProduit->getProduit() === $this) {
                $commandeProduit->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favori>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favori $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
            $favori->setProduit($this);
        }

        return $this;
    }

    public function removeFavori(Favori $favori): static
    {
        if ($this->favoris->removeElement($favori)) {
            if ($favori->getProduit() === $this) {
                $favori->setProduit(null);
            }
        }

        return $this;
    }
}
