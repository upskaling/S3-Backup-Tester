<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BucketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BucketRepository::class)]
class Bucket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $endpoint = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $region = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $credentials_key = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $credentials_secret = null;

    /**
     * @var Collection<int, BucketTest>
     */
    #[ORM\OneToMany(mappedBy: 'Bucket', targetEntity: BucketTest::class)]
    private Collection $bucketTests;

    /**
     * @var Collection<int, Incident>
     */
    #[ORM\OneToMany(mappedBy: 'bucket', targetEntity: Incident::class, orphanRemoval: true)]
    private Collection $incidents;

    public function __construct()
    {
        $this->bucketTests = new ArrayCollection();
        $this->incidents = new ArrayCollection();
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

    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): static
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getCredentialsKey(): ?string
    {
        return $this->credentials_key;
    }

    public function setCredentialsKey(string $credentials_key): static
    {
        $this->credentials_key = $credentials_key;

        return $this;
    }

    public function getCredentialsSecret(): ?string
    {
        return $this->credentials_secret;
    }

    public function setCredentialsSecret(string $credentials_secret): static
    {
        $this->credentials_secret = $credentials_secret;

        return $this;
    }

    /**
     * @return Collection<int, BucketTest>
     */
    public function getBucketTests(): Collection
    {
        return $this->bucketTests;
    }

    public function addBucketTest(BucketTest $bucketTest): static
    {
        if (!$this->bucketTests->contains($bucketTest)) {
            $this->bucketTests->add($bucketTest);
            $bucketTest->setBucket($this);
        }

        return $this;
    }

    public function removeBucketTest(BucketTest $bucketTest): static
    {
        if ($this->bucketTests->removeElement($bucketTest)) {
            // set the owning side to null (unless already changed)
            if ($bucketTest->getBucket() === $this) {
                $bucketTest->setBucket(null);
            }
        }

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
            $incident->setBucket($this);
        }

        return $this;
    }

    public function removeIncident(Incident $incident): static
    {
        if ($this->incidents->removeElement($incident)) {
            // set the owning side to null (unless already changed)
            if ($incident->getBucket() === $this) {
                $incident->setBucket(null);
            }
        }

        return $this;
    }
}
