<?php

namespace App\Entity;

use App\Repository\EsameRepository;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\Entity(repositoryClass: EsameRepository::class)]
class Esame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'esami')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Studente $studente = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $dataSvolgimento = "";

    #[ORM\ManyToOne(inversedBy: 'esami')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Corso $corso = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?int $voto = 17;

    #[ORM\Column]
    private ?bool $accettato = false;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

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

    public function getDataSvolgimento(): ?string
    {
        return $this->dataSvolgimento;
    }

    public function setDataSvolgimento(string $dataSvolgimento): static
    {
        $this->dataSvolgimento = $dataSvolgimento;
        return $this;
    }

    public function getCorso(): ?Corso
    {
        return $this->corso;
    }

    public function setCorso(?Corso $corso): static
    {
        $this->corso = $corso;
        return $this;
    }

    public function getVoto(): ?string
    {
        return $this->voto;
    }

    public function setVoto(?string $voto): static
    {
        $this->voto = $voto;

        return $this;
    }

    public function isAccettato(): ?bool
    {
        return $this->accettato;
    }

    /**
     * @throws Exception
     */
    public function setAccettato(bool $accettato): static
    {
        $this->accettato = $accettato;
        return $this;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'data_svolgimento' => $this->dataSvolgimento,
            'corso' => $this->corso->getId(),
            'voto' => $this->voto,
            'accettato' => $this->accettato,
        ];
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }
}
