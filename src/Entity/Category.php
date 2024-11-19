<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[Vich\Uploadable]
class Category
{

    const DEFAULT_SERIALIZATION_GROUP =[
        'category_main', 
        'category_join',
        'article_join',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category_main', 'category_join'])]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    #[Groups(['category_main','category_join'])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['category_main'])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    // TODO:gerer les int
    // #[Assert\Type(
    //     type: 'string',
    //     message: 'The value {{ value }} is not a valid {{ type }}.',
    // )]
    private ?int $home_order = null;


    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['category_main','category_join'])]
    private ?string $picture = null;


    #[Vich\UploadableField(mapping: 'category', fileNameProperty: 'picture')]
    #[Assert\Image(
        minWidth: 1,
        maxWidth: 1200,
        minHeight: 1,
        maxHeight: 1200,
    )]

    #[Assert\File(
        mimeTypes: ['image/jpg', 'image/jpeg', 'image/png'],
        mimeTypesMessage: "Please upload a valid PNG or JPEG image",
        maxSize: "2M",
        maxSizeMessage: "The maximum allowed file size is 2MB"
    )]
    #[Groups(['category_main'])]
    private ?File $pictureFileCategory = null;
    
    /**
     * @var Collection<int, Article>
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'category')]
    #[Groups(['category_main'])]
    private Collection $articles;


#[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
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

    public function getHomeOrder(): ?int
    {
        return $this->home_order;
    }

    public function setHomeOrder(int $home_order): static
    {
        $this->home_order = $home_order;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

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

 public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

      /**
     * Get the value of pictureFileCategory
     */ 
    public function getPictureFileCategory()
    {
        return $this->pictureFileCategory;
    }

    /**
     * Set the value of pictureFileCategory
     *
     * @return  self
     */ 
    public function setPictureFileCategory($pictureFileCategory)
    {
        $this->pictureFileCategory = $pictureFileCategory;

        if (null !== $pictureFileCategory) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated_at = new \DateTimeImmutable();
        }
    }



}
