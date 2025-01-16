<?php

namespace App\Entity;

use App\Repository\TassaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TassaRepository::class)]
class Tassa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $aaId = null;

    #[ORM\Column]
    private ?int $fattId = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descrizione = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $data_emissione = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $data_pagamento = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $scadenza = null;

    #[ORM\Column]
    private ?float $importo = null;

    #[ORM\ManyToOne(inversedBy: 'tasse')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Studente $id_studente = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAaId(): ?int
    {
        return $this->aaId;
    }

    public function setAaId(int $aaId): static
    {
        $this->aaId = $aaId;

        return $this;
    }

    public function getFattId(): ?int
    {
        return $this->fattId;
    }

    public function setFattId(int $fattId): static
    {
        $this->fattId = $fattId;

        return $this;
    }

    public function getDescrizione(): ?string
    {
        return $this->descrizione;
    }

    public function setDescrizione(string $descrizione): static
    {
        $this->descrizione = $descrizione;

        return $this;
    }

    public function getDataEmissione(): ?\DateTimeInterface
    {
        return $this->data_emissione;
    }

    public function setDataEmissione(\DateTimeInterface $data_emissione): static
    {
        $this->data_emissione = $data_emissione;

        return $this;
    }

    public function getDataPagamento(): ?\DateTimeInterface
    {
        return $this->data_pagamento;
    }

    public function setDataPagamento(?\DateTimeInterface $data_pagamento): static
    {
        $this->data_pagamento = $data_pagamento;

        return $this;
    }

    public function getScadenza(): ?\DateTimeInterface
    {
        return $this->scadenza;
    }

    public function setScadenza(\DateTimeInterface $scadenza): static
    {
        $this->scadenza = $scadenza;

        return $this;
    }

    public function getImporto(): ?float
    {
        return $this->importo;
    }

    public function setImporto(float $importo): static
    {
        $this->importo = $importo;

        return $this;
    }

    public function getIdStudente(): ?Studente
    {
        return $this->id_studente;
    }

    public function setIdStudente(?Studente $id_studente): static
    {
        $this->id_studente = $id_studente;

        return $this;
    }
}
