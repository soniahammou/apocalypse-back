<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[Groups('type_main')]
#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    CONST DEFAULT_SERIALIZATION_GROUP = [
        'type_main',
        'pinpoint_join'
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('type_join')]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    #[Groups('type_join')]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(max: 64)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups('type_join')]
    #[Assert\NotBlank]
    #[Assert\Url]
    private ?string $icon_url = null;

    /**
     * @var Collection<int, Pinpoint>
     */
    #[ORM\OneToMany(targetEntity: Pinpoint::class, mappedBy: 'type', orphanRemoval: true)]
    private Collection $pinpoints;

    public function __construct()
    {
        $this->pinpoints = new ArrayCollection();
    }

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIconUrl(): ?string
    {
        return $this->icon_url;
    }

    public function setIconUrl(string $icon_url): static
    {
        $this->icon_url = $icon_url;

        return $this;
    }

    /**
     * @return Collection<int, Pinpoint>
     */
    public function getPinpoints(): Collection
    {
        return $this->pinpoints;
    }

    public function addPinpoint(Pinpoint $pinpoint): static
    {
        if (!$this->pinpoints->contains($pinpoint)) {
            $this->pinpoints->add($pinpoint);
            $pinpoint->setType($this);
        }

        return $this;
    }

    public function removePinpoint(Pinpoint $pinpoint): static
    {
        if ($this->pinpoints->removeElement($pinpoint)) {
            // set the owning side to null (unless already changed)
            if ($pinpoint->getType() === $this) {
                $pinpoint->setType(null);
            }
        }

        return $this;
    }

  
}
