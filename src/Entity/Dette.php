<?php

namespace App\Entity;

use App\Repository\DetteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetteRepository::class)]
class Dette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'dettes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column]
    private ?float $MontantVersee = null;

    #[ORM\Column]
    private ?float $MontantRestant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMontantVersee(): ?float
    {
        return $this->MontantVersee;
    }

    public function setMontantVersee(float $MontantVersee): static
    {
        $this->MontantVersee = $MontantVersee;

        return $this;
    }

    public function getMontantRestant(): ?float
    {
        return $this->MontantRestant;
    }

    public function setMontantRestant(float $MontantRestant): static
    {
        $this->MontantRestant = $MontantRestant;

        return $this;
    }
}
