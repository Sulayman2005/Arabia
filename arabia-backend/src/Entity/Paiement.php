<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PaiementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
#[ApiResource(
    operations: [new Get(), new GetCollection()],
    normalizationContext: ['groups' => ['paiement:read']]
)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['paiement:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Groups(['paiement:read'])]
    #[Assert\NotBlank(message: "Le moyen de paiement est obligatoire.")]
    private ?string $moyenPaiement = null;

    #[ORM\Column(length: 30)]
    #[Groups(['paiement:read'])]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['paiement:read'])]
    private ?\DateTime $datePaiement = null;

    // Paiement appartient à UNE commande (et une commande a UN paiement)
    #[ORM\OneToOne(inversedBy: 'paiement', targetEntity: Commande::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['paiement:read'])]
    #[Assert\NotNull(message: "Le paiement doit être lié à une commande.")]
    private ?Commande $commande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoyenPaiement(): ?string
    {
        return $this->moyenPaiement;
    }

    public function setMoyenPaiement(string $moyenPaiement): static
    {
        $this->moyenPaiement = $moyenPaiement;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    public function getDatePaiement(): ?\DateTime
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(\DateTime $datePaiement): static
    {
        $this->datePaiement = $datePaiement;
        return $this;
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
}
