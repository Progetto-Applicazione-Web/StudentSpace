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

    #[ORM\ManyToOne(inversedBy: 'tasse')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Studente $studente = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $importo = null;

    #[ORM\Column(length: 10)]
    private ?string $dataScadenza = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $dataPagamento = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descrizione = null;

    #[ORM\Column(nullable: true)]
    private ?int $fattId = null;

    #[ORM\Column]
    private ?bool $pagato = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudente(): ?Studente
    {
        return $this->studente;
    }

    public function setStudente(?Studente $studente): static
    {
        $this->studente = $studente;

        return $this;
    }

    public function getImporto(): ?string
    {
        return $this->importo;
    }

    public function setImporto(string $importo): static
    {
        $this->importo = $importo;

        return $this;
    }

    public function getDataScadenza(): ?string
    {
        return $this->dataScadenza;
    }

    public function setDataScadenza(string $dataScadenza): static
    {
        $this->dataScadenza = $dataScadenza;

        return $this;
    }

    public function getDataPagamento(): ?string
    {
        return $this->dataPagamento;
    }

    public function setDataPagamento(?string $dataPagamento): static
    {
        $this->dataPagamento = $dataPagamento;

        return $this;
    }

    public function getDescrizione(): ?string
    {
        return $this->descrizione;
    }

    public function setDescrizione(?string $descrizione): static
    {
        $this->descrizione = $descrizione;

        return $this;
    }

    public function getFattId(): ?int
    {
        return $this->fattId;
    }

    public function setFattId(?int $fattId): static
    {
        $this->fattId = $fattId;

        return $this;
    }

    public function hasFattId(): bool
    {
        return isset($this->fattId);
    }

    public function isPagato(): ?bool
    {
        return $this->pagato;
    }

    public function setPagato(bool $pagato): static
    {
        $this->pagato = $pagato;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'importo' => $this->importo,
            'data_scadenza' => $this->dataScadenza,
            'data_pagamento' => $this->dataPagamento,
            'descrizione' => $this->descrizione,
            'fatt_id' => $this->fattId,
            'pagato' => $this->pagato
        ];
    }
}
