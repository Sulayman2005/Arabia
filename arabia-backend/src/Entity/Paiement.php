<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $moyenPaiement = null;

    #[ORM\Column(length: 30)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $datePaiement = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
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
