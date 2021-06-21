<?php

namespace App\Entity;

use App\Repository\DumpRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DumpRepository::class)
 */
class Dump
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"browse", "read"})
     * @Groups({"removal_browse", "removal_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"browse", "read"})
     * @Groups({"removal_browse", "removal_read"})
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     * @Groups({"browse", "read"})
     */
    private $latitudeCoordinate;

    /**
     * @ORM\Column(type="float")
     * @Groups({"browse", "read"})
     */
    private $longitudeCoordinate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse", "read"})
     */
    private $picture1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"browse", "read"})
     */
    private $picture2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"browse", "read"})
     */
    private $picture3;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"browse", "read"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     * @Groups({"browse", "read"})
     */
    private $isClosed;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"browse", "read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Emergency::class, inversedBy="dumps")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"browse", "read"})
     */
    private $emergency;

    /**
     * @ORM\ManyToMany(targetEntity=Waste::class, inversedBy="dumps")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"browse", "read"})
     */
    private $wastes;

    /**
     * @ORM\OneToMany(targetEntity=Removal::class, mappedBy="dump", orphanRemoval=true)
     * @Groups({"browse", "read"})
     */
    private $removals;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="dumps")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"browse", "read"})
     */
    private $user;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->wastes = new ArrayCollection();
        $this->removals = new ArrayCollection();
    }

    public function __toString()
    {
        // return $this->user;

        return $this->wastes;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLatitudeCoordinate(): ?float
    {
        return $this->latitudeCoordinate;
    }

    public function setLatitudeCoordinate(float $latitudeCoordinate): self
    {
        $this->latitudeCoordinate = $latitudeCoordinate;

        return $this;
    }

    public function getLongitudeCoordinate(): ?float
    {
        return $this->longitudeCoordinate;
    }

    public function setLongitudeCoordinate(float $longitudeCoordinate): self
    {
        $this->longitudeCoordinate = $longitudeCoordinate;

        return $this;
    }

    public function getPicture1(): ?string
    {
        return $this->picture1;
    }

    public function setPicture1(string $picture1): self
    {
        $this->picture1 = $picture1;

        return $this;
    }

    public function getPicture2(): ?string
    {
        return $this->picture2;
    }

    public function setPicture2(?string $picture2): self
    {
        $this->picture2 = $picture2;

        return $this;
    }

    public function getPicture3(): ?string
    {
        return $this->picture3;
    }

    public function setPicture3(?string $picture3): self
    {
        $this->picture3 = $picture3;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsClosed(): ?bool
    {
        return $this->isClosed;
    }

    public function setIsClosed(bool $isClosed): self
    {
        $this->isClosed = $isClosed;

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

    public function getEmergency(): ?Emergency
    {
        return $this->emergency;
    }

    public function setEmergency(?Emergency $emergency): self
    {
        $this->emergency = $emergency;

        return $this;
    }

    /**
     * @return Collection|Waste[]
     */
    public function getWastes(): Collection
    {
        return $this->wastes;
    }

    public function addWastes(Waste $wastes): self
    {
        if (!$this->wastes->contains($wastes)) {
            $this->wastes[] = $wastes;
        }

        return $this;
    }

    public function removeWaste(Waste $wastes): self
    {
        $this->wastes->removeElement($wastes);

        return $this;
    }

    /**
     * @return Collection|Removal[]
     */
    public function getRemovals(): Collection
    {
        return $this->removals;
    }

    public function addRemovals(Removal $removals): self
    {
        if (!$this->removals->contains($removals)) {
            $this->removals[] = $removals;
            $removals->setDump($this);
        }

        return $this;
    }

    public function removeRemoval(Removal $removals): self
    {
        if ($this->removals->removeElement($removals)) {
            // set the owning side to null (unless already changed)
            if ($removals->getDump() === $this) {
                $removals->setDump(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
