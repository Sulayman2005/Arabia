<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CommandeProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CommandeProduitRepository::class)]
#[ApiResource(
    operations: [new Get(), new GetCollection()],
    normalizationContext: ['groups' => ['commandeProduit:read']]
)]
class CommandeProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['commandeProduit:read', 'commande:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandeProduits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['commandeProduit:read'])]
    private ?Commande $commande = null;

    #[ORM\ManyToOne(inversedBy: 'commandeProduits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['commandeProduit:read'])]
    private ?Produit $produit = null;

    #[ORM\Column]
    #[Groups(['commandeProduit:read'])]
    private ?int $quantite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;
        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;
        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;
        return $this;
    }
}
