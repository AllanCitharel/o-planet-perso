<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"browse", "read"})
     * @Groups({"user_browse","user_read"})
     * @Groups({"removal_browse", "removal_read"})
     * @Groups({"subscribeToRemoval"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user_browse","user_read"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user_browse"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"browse", "read"})
     * @Groups({"user_read"})
     * @Groups({"removal_browse", "removal_read"})
     * @Groups({"subscribeToRemoval"})
     */
    private $userAlias;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"user_read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"user_read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user_browse"})
     * @Groups({"user_read"})
     */
    private $isBanned;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"user_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user_read"})
     */
    private $updatedAt;

       /**
     * @ORM\OneToMany(targetEntity=Dump::class, mappedBy="user")
     */
    private $dumps;

    /**
     * @ORM\OneToMany(targetEntity=Removal::class, mappedBy="creator")
     */
    private $removals;

    /**
     * @ORM\ManyToMany(targetEntity=Removal::class, inversedBy="subscribers")
     */
    private $subscribedRemoval;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnectionAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->dumps = new ArrayCollection();
        $this->removals = new ArrayCollection();
        $this->subscribedRemoval = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->userAlias;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): self
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUserAlias(): ?string
    {
        return $this->userAlias;
    }

    public function setUserAlias(string $userAlias): self
    {
        $this->userAlias = $userAlias;

        return $this;
    }

     /**
     * @return Collection|Dump[]
     */
    public function getDumps(): Collection
    {
        return $this->dumps;
    }

    public function addDump(Dump $dump): self
    {
        if (!$this->dumps->contains($dump)) {
            $this->dumps[] = $dump;
            $dump->setUser($this);
        }

        return $this;
    }

    public function removeDump(Dump $dump): self
    {
        if ($this->dumps->removeElement($dump)) {
            // set the owning side to null (unless already changed)
            if ($dump->getUser() === $this) {
                $dump->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Removal[]
     */
    public function getRemovals(): Collection
    {
        return $this->removals;
    }

    public function addRemoval(Removal $removal): self
    {
        if (!$this->removals->contains($removal)) {
            $this->removals[] = $removal;
            $removal->setCreator($this);
        }

        return $this;
    }

    public function removeRemoval(Removal $removal): self
    {
        if ($this->removals->removeElement($removal)) {
            // set the owning side to null (unless already changed)
            if ($removal->getCreator() === $this) {
                $removal->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Removal[]
     */
    public function getSubscribedRemoval(): Collection
    {
        return $this->subscribedRemoval;
    }

    public function addSubscribedRemoval(Removal $subscribedRemoval): self
    {
        if (!$this->subscribedRemoval->contains($subscribedRemoval)) {
            $this->subscribedRemoval[] = $subscribedRemoval;
        }

        return $this;
    }

    public function removeSubscribedRemoval(Removal $subscribedRemoval): self
    {
        $this->subscribedRemoval->removeElement($subscribedRemoval);

        return $this;
    }

    public function getLastConnectionAt(): ?\DateTimeInterface
    {
        return $this->lastConnectionAt;
    }

    public function setLastConnectionAt(?\DateTimeInterface $lastConnectionAt): self
    {
        $this->lastConnectionAt = $lastConnectionAt;

        return $this;
    }
}
