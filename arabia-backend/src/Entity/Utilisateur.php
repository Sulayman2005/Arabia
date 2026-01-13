<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\UtilisateurRepository;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    operations: [new Get(), new GetCollection()],
    normalizationContext: ['groups' => ['utilisateur:read']]
)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['utilisateur:read', 'commande:read', 'favori:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['utilisateur:read', 'commande:read', 'favori:read'])]
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Groups(['utilisateur:read'])]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Groups(['utilisateur:read'])]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    private ?string $prenom = null;

    

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['utilisateur:read'])]
    #[Assert\NotNull(message: "La date d'inscription est obligatoire.")]
    private ?\DateTime $dateInscription = null;


    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Commande::class)]
    private Collection $commandes;

    /**
     * @var Collection<int, Favori>
     */
    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Favori::class, orphanRemoval: true)]
    private Collection $favoris;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }



    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }


    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateInscription(): ?\DateTime
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTime $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }


    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

}
