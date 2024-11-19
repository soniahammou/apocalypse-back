<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PasswordStrength;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity('email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    CONST DEFAULT_SERIALIZATION_GROUP = [
        'user_main',
        'user_join',
        'article_join',
        'search-notice_join',
        'pinpoint_join'

    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user_main','user_join'])]
    private ?int $id = null;

   // #[ORM\Column(length: 180)]
   #[ORM\Column(name: 'email', type: 'string', length: 255, unique: true)]
    #[Groups(['user_main','user_join'])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    // TODO:a voir comment faire pour le type
   // #[Assert\Type(Email::class)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['user_main','user_join'])]
    // #[Assert\Type(type: ['ROLE_USER', 'ROLE_ADMIN'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\NotNull]
 /*   #[Assert\PasswordStrength([
        'minScore' => PasswordStrength::STRENGTH_WEAK, // en dev STRENGTH_WEAK mais en PROD : STRENGTH_VERY_STRONG
        'message' => 'Your password is too easy to guess. Company\'s security policy requires to use a stronger password.'

    ])]*/
    private ?string $password = null;

    #[ORM\Column(length: 64)]
    #[Groups(['user_main','user_join'])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type('string')]
    private ?string $firstname = null;

    #[ORM\Column(length: 64)]
    #[Groups(['user_main','user_join'])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type('string')]
    private ?string $lastname = null;

    /**
     * @var Collection<int, Pinpoint>
     */
    #[ORM\OneToMany(targetEntity: Pinpoint::class, mappedBy: 'user')]
    #[Groups(['user_main'])]
    private Collection $pinpoints;

    /**
     * @var Collection<int, SearchNotice>
     */
    #[ORM\OneToMany(targetEntity: SearchNotice::class, mappedBy: 'user', orphanRemoval: true)]
    #[Groups(['user_main'])]
    private Collection $searchNotices;

    /**
     * @var Collection<int, Question>
     */
    #[ORM\OneToMany(targetEntity: Question::class, mappedBy: 'user')]
    #[Groups(['user_main'])]
    private Collection $questions;

    /**
     * @var Collection<int, Answer>
     */
    #[ORM\OneToMany(targetEntity: Answer::class, mappedBy: 'user')]
    #[Groups(['user_main'])]
    private Collection $answers;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'user')]
    #[Groups(['user_main'])]
    private Collection $articles;

    public function __construct()
    {
        $this->pinpoints = new ArrayCollection();
        $this->searchNotices = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->articles = new ArrayCollection();
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
     *
     * @return list<string>
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
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $pinpoint->setUser($this);
        }

        return $this;
    }

    public function removePinpoint(Pinpoint $pinpoint): static
    {
        if ($this->pinpoints->removeElement($pinpoint)) {
            // set the owning side to null (unless already changed)
            if ($pinpoint->getUser() === $this) {
                $pinpoint->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SearchNotice>
     */
    public function getSearchNotices(): Collection
    {
        return $this->searchNotices;
    }

    public function addSearchNotice(SearchNotice $searchNotice): static
    {
        if (!$this->searchNotices->contains($searchNotice)) {
            $this->searchNotices->add($searchNotice);
            $searchNotice->setUser($this);
        }

        return $this;
    }

    public function removeSearchNotice(SearchNotice $searchNotice): static
    {
        if ($this->searchNotices->removeElement($searchNotice)) {
            // set the owning side to null (unless already changed)
            if ($searchNotice->getUser() === $this) {
                $searchNotice->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setUser($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getUser() === $this) {
                $question->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): static
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setUser($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): static
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getUser() === $this) {
                $answer->setUser(null);
            }
        }

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
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }
}
