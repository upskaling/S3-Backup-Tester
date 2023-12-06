<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BucketTestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BucketTestRepository::class)]
class BucketTest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bucketTests')]
    #[Assert\NotBlank]
    private ?Bucket $Bucket = null;

    /**
     * Un temps en seconde Par rapport à la date d'aujourd'hui Pour lequel le fichier est encore valide.
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    private ?int $interval = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBucket(): ?Bucket
    {
        return $this->Bucket;
    }

    public function setBucket(?Bucket $Bucket): static
    {
        $this->Bucket = $Bucket;

        return $this;
    }

    public function getInterval(): ?int
    {
        return $this->interval;
    }

    public function setInterval(int $interval): static
    {
        $this->interval = $interval;

        return $this;
    }
}
