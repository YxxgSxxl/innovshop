<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isLiked = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?Comment $comments = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLiked(): ?bool
    {
        return $this->isLiked;
    }

    public function setLiked(?bool $isLiked): static
    {
        $this->isLiked = $isLiked;

        return $this;
    }

    public function getComments(): ?Comment
    {
        return $this->comments;
    }

    public function setComments(?Comment $comments): static
    {
        $this->comments = $comments;

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
