<?php

namespace App\Entity;

use App\Repository\RemovalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RemovalRepository::class)
 */
class Removal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"browse", "read"})
     * @Groups({"removal_browse", "removal_read"})
     * @Groups({"subscribeToRemoval"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"browse", "read"})
     * @Groups({"removal_browse", "removal_read"})
     * @Groups({"subscribeToRemoval"})
     */
    private $date;

    /**
     * @ORM\Column(type="boolean", options={"default"= 0})
     * @Groups({"browse", "read"})
     * @Groups({"removal_browse", "removal_read"})
     * @Groups({"subscribeToRemoval"})
     */
    private $isFinished;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"removal_browse", "removal_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"removal_browse", "removal_read"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Dump::class, inversedBy="removals")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"removal_browse", "removal_read"})
     */
    private $dump;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="removals")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"browse", "read"})
     * @Groups({"removal_browse", "removal_read"})
     */
    private $creator;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="subscribedRemoval")
     * @Groups({"browse", "read"})
     * @Groups({"subscribeToRemoval"})
     */
    private $subscribers;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->users = new ArrayCollection();
    }

    public function __toString()
    {
        $date = date('d/m/Y', date_timestamp_get($this->date));
        return $date;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): self
    {
        $this->isFinished = $isFinished;

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

    public function getDump(): ?Dump
    {
        return $this->dump;
    }

    public function setDump(?Dump $dump): self
    {
        $this->dump = $dump;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getSubscribers(): Collection
    {
        return $this->subscribers;
    }

    public function addUser(User $user): self
    {
        if (!$this->subscribers->contains($user)) {
            $this->subscribers[] = $user;
            $user->addSubscribedRemoval($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeSubscribedRemoval($this);
        }

        return $this;
    }
}
