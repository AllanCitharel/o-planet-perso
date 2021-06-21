<?php

namespace App\Entity;

use App\Repository\WasteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=WasteRepository::class)
 */
class Waste
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"browse", "read"})
     * @Groups({"emergency_and_waste"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"browse", "read"})
     * @Groups({"emergency_and_waste"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Dump::class, mappedBy="wastes")
     */
    private $dumps;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->dumps = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $dump->addWastes($this);
        }

        return $this;
    }

    public function removeDump(Dump $dump): self
    {
        if ($this->dumps->removeElement($dump)) {
            $dump->removeWaste($this);
        }

        return $this;
    }
}
