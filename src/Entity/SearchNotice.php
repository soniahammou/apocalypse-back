<?php

namespace App\Entity;

use App\Repository\SearchNoticeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Groups('search-notice_main')]
#[ORM\Entity(repositoryClass: SearchNoticeRepository::class)]
#[Vich\Uploadable]

class SearchNotice
{
    CONST DEFAULT_SERIALIZATION_GROUP = [
        'search-notice_main',
        'user_join',
        'report_join',
        'city_join',
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('search-notice_join')]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    #[Groups('search-notice_join')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\Type('string')]
    private ?string $firstname = null;

    #[ORM\Column(length: 64)]
    #[Groups('search-notice_join')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\Type('string')]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    private ?string $home = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive]
    private ?int $age = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    private ?string $picture = null;

    #[ORM\Column]
    #[Groups('search-notice_join')]
    #[Assert\Range(min: 0, max: 1)]
    private ?int $status = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'searchNotices')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private ?User $user = null;

    /**
     * @var Collection<int, Report>
     */
    #[ORM\OneToMany(targetEntity: Report::class, mappedBy: 'search_notice')]
    private Collection $reports;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('search-notice_join')]
    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    private ?string $latest_city = null;

    #[ORM\Column(nullable: true)]
    #[Groups('search-notice_join')]
    private ?\DateTimeImmutable $latest_date = null;

    #[Vich\UploadableField(mapping: 'searchnotices', fileNameProperty: 'picture')]
    #[Assert\Image(
        minWidth: 1,
        maxWidth: 1500,
        maxHeight: 1500,
        minHeight: 1,
    )]

    #[Assert\File(
        maxSize: "2M",
        mimeTypes: ['image/jpg', 'image/jpeg', 'image/png'],
        maxSizeMessage: "The maximum allowed file size is 2MB",
        mimeTypesMessage: "Please upload a valid PNG or JPEG image"
    )]

    private ?File $pictureFile = null;

    public function __construct()
    {
        $this->reports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Report>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Report $report): static
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setSearchNotice($this);
        }

        return $this;
    }

    public function removeReport(Report $report): static
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getSearchNotice() === $this) {
                $report->setSearchNotice(null);
            }
        }

        return $this;
    }

    public function getHome(): ?string
    {
        return $this->home;
    }

    public function setHome(?string $home): static
    {
        $this->home = $home;

        return $this;
    }

    public function getLatestCity(): ?string
    {
        return $this->latest_city;
    }

    public function setLatestCity(?string $latest_city): static
    {
        $this->latest_city = $latest_city;

        return $this;
    }

    public function getLatestDate(): ?\DateTimeImmutable
    {
        return $this->latest_date;
    }

    public function setLatestDate(?\DateTimeImmutable $latest_date): static
    {
        $this->latest_date = $latest_date;

        return $this;
    }

    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    /**
     * Set the value of pictureFile
     *
     * @param $pictureFile
     * @return  self
     */
    public function setPictureFile($pictureFile)
    {
        $this->pictureFile = $pictureFile;

        if (null !== $pictureFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated_at = new \DateTimeImmutable();
        }
    }

}
