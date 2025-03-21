<?php

namespace App\Entity;

use App\Repository\TraitementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource(    
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    operations: [
        new GetCollection(security: "is_granted('ROLE_VETERINARIAN')", securityMessage: 'you can not do this action'),
        new Post(security: "is_granted('ROLE_VETERINARIAN')", securityMessage: 'you can not do this action'),
        new Get(security: "is_granted('ROLE_VETERINARIAN')", securityMessage: 'you can not do this action'),
        new Patch(security: "is_granted('ROLE_VETERINARIAN')", securityMessage: 'you can not do this action'),
        new Delete(security: "is_granted('ROLE_VETERINARIAN')", securityMessage: 'you can not do this action'),
    ],
)]
#[ORM\Entity(repositoryClass: TraitementRepository::class)]
class Traitement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]

    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read', 'write'])]

    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]

    private ?float $prix = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?\DateInterval $durée = null;

    /**
     * @var Collection<int, Consultation>
     */
    #[ORM\ManyToMany(targetEntity: Consultation::class, mappedBy: 'traitements')]
    #[Groups('read')]
    private Collection $consultations;

    public function __construct()
    {
        $this->consultations = new ArrayCollection();
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDurée(): ?\DateInterval
    {
        return $this->durée;
    }

    public function setDurée(\DateInterval $durée): static
    {
        $this->durée = $durée;

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): static
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations->add($consultation);
            $consultation->addTraitement($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultations->removeElement($consultation)) {
            $consultation->removeTraitement($this);
        }

        return $this;
    }
}
