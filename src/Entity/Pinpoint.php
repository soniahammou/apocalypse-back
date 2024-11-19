<?php

namespace App\Entity;

use App\Repository\PinpointRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[Groups('pinpoint_main',)]
#[ORM\Entity(repositoryClass: PinpointRepository::class)]
class Pinpoint
{
    CONST DEFAULT_SERIALIZATION_GROUP = [
        'pinpoint_main',
        'user_join',
        'type_join',
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('pinpoint_join')]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('pinpoint_join')]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column]
    #[Groups('pinpoint_join')]
    #[Assert\NotBlank]
    #[Assert\Type('float')]
    private ?float $latitude = null;

    #[ORM\Column]
    #[Groups('pinpoint_join')]
    #[Assert\NotBlank]
    #[Assert\Type('float')]
    private ?float $longitude = null;

    #[ORM\ManyToOne(inversedBy: 'pinpoints')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Type $type = null;

    #[ORM\ManyToOne(inversedBy: 'pinpoints')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $user = null;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

}
