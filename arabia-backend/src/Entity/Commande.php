<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    operations: [new Get(), new GetCollection()],
    normalizationContext: ['groups' => ['commande:read']]
)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['commande:read', 'commandeProduit:read', 'paiement:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['commande:read'])]
    #[Assert\NotNull(message: "La date de commande est obligatoire.")]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(length: 30)]
    #[Groups(['commande:read'])]
    #[Assert\NotBlank(message: "Le statut est obligatoire.")]
    #[Assert\Choice(
        choices: ["en cours", "payée", "expédiée", "livrée", "annulée"],
        message: "Statut invalide."
    )]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['commande:read'])]
    #[Assert\NotBlank(message: "Le total est obligatoire.")]
    private ?string $total = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['commande:read'])]
    #[Assert\NotNull(message: "Une commande doit avoir un utilisateur.")]
    private ?Utilisateur $utilisateur = null;

    /**
     * @var Collection<int, CommandeProduit>
     */
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeProduit::class, orphanRemoval: true)]
    #[Groups(['commande:read'])]
    private Collection $commandeProduits;

    #[ORM\OneToOne(mappedBy: 'commande', targetEntity: Paiement::class, cascade: ['persist', 'remove'])]
    #[Groups(['commande:read'])]
    private ?Paiement $paiement = null;

    public function __construct()
    {
        $this->commandeProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    /**
     * @return Collection<int, CommandeProduit>
     */
    public function getCommandeProduits(): Collection
    {
        return $this->commandeProduits;
    }

    public function addCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if (!$this->commandeProduits->contains($commandeProduit)) {
            $this->commandeProduits->add($commandeProduit);
            $commandeProduit->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if ($this->commandeProduits->removeElement($commandeProduit)) {
            if ($commandeProduit->getCommande() === $this) {
                $commandeProduit->setCommande(null);
            }
        }

        return $this;
    }

    public function getPaiement(): ?Paiement
    {
        return $this->paiement;
    }

    public function setPaiement(?Paiement $paiement): self
    {
        $this->paiement = $paiement;

        // Maintenir la cohérence bidirectionnelle
        if ($paiement !== null && $paiement->getCommande() !== $this) {
            $paiement->setCommande($this);
        }

        return $this;
    }
}
