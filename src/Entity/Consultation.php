<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource(    
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']]
)]
#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('read')]
    private ?\DateTimeInterface $createdDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('read', 'write')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('read', 'write')]
    private ?string $motif = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    private ?User $assistant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $veterinaire = null;

    #[ORM\Column(length: 255)]
    #[Groups('read', 'write')]
    private ?string $statut = null;

    /**
     * @var Collection<int, Traitement>
     */
    #[ORM\ManyToMany(targetEntity: Traitement::class, inversedBy: 'consultations')]
    private Collection $traitements;

    public function __construct()
    {
        $this->traitements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): static
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getAssistant(): ?User
    {
        return $this->assistant;
    }

    public function setAssistant(?User $assistant): static
    {
        $this->assistant = $assistant;

        return $this;
    }

    public function getVeterinaire(): ?User
    {
        return $this->veterinaire;
    }

    public function setVeterinaire(?User $veterinaire): static
    {
        $this->veterinaire = $veterinaire;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        if ($statut !== 'programmé' && $statut !== 'en cours' && $statut !== 'terminé') {
            # code...
        } else {
            $this->statut = $statut;
        }


        return $this;
    }

    /**
     * @return Collection<int, Traitement>
     */
    public function getTraitements(): Collection
    {
        return $this->traitements;
    }

    public function addTraitement(Traitement $traitement): static
    {
        if (!$this->traitements->contains($traitement)) {
            $this->traitements->add($traitement);
        }

        return $this;
    }

    public function removeTraitement(Traitement $traitement): static
    {
        $this->traitements->removeElement($traitement);

        return $this;
    }
}
