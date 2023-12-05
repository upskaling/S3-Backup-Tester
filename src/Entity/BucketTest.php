<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BucketTestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Incident>
     */
    #[ORM\OneToMany(mappedBy: 'BucketTest', targetEntity: Incident::class, orphanRemoval: true)]
    private Collection $incidents;

    public function __construct()
    {
        $this->incidents = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Incident>
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    public function addIncident(Incident $incident): static
    {
        if (!$this->incidents->contains($incident)) {
            $this->incidents->add($incident);
            $incident->setBucketTest($this);
        }

        return $this;
    }

    public function removeIncident(Incident $incident): static
    {
        if ($this->incidents->removeElement($incident)) {
            // set the owning side to null (unless already changed)
            if ($incident->getBucketTest() === $this) {
                $incident->setBucketTest(null);
            }
        }

        return $this;
    }
}
