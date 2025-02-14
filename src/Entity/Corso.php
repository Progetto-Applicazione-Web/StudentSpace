<?php

namespace App\Entity;

use App\Repository\CorsoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CorsoRepository::class)]
class Corso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'corsi')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Studente $studente = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codice = null;

    #[ORM\Column(length: 510, nullable: true)]
    private ?string $docente = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $annoSvolgimento = null;

    /**
     * @var Collection<int, Esame>
     */
    #[ORM\OneToMany(targetEntity: Esame::class, mappedBy: 'corso')]
    private Collection $esami;

    #[ORM\Column]
    private ?int $cfu = null;

    public function __construct()
    {
        $this->esami = new ArrayCollection();
    }

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

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCodice(): ?string
    {
        return $this->codice;
    }

    public function setCodice(?string $codice): static
    {
        $this->codice = $codice;

        return $this;
    }

    public function getDocente(): ?string
    {
        return $this->docente;
    }

    public function setDocente(?string $docente): static
    {
        $this->docente = $docente;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getAnnoSvolgimento(): ?string
    {
        return $this->annoSvolgimento;
    }

    public function setAnnoSvolgimento(?string $annoSvolgimento): static
    {
        $this->annoSvolgimento = $annoSvolgimento;

        return $this;
    }

    /**
     * @return Collection<int, Esame>
     */
    public function getEsami(): Collection
    {
        return $this->esami;
    }

    public function addEsami(Esame $esami): static
    {
        if (!$this->esami->contains($esami)) {
            $this->esami->add($esami);
            $esami->setCorso($this);
        }

        return $this;
    }

    public function removeEsami(Esame $esami): static
    {
        if ($this->esami->removeElement($esami)) {
            // set the owning side to null (unless already changed)
            if ($esami->getCorso() === $this) {
                $esami->setCorso(null);
            }
        }

        return $this;
    }

    public function getCfu(): ?int
    {
        return $this->cfu;
    }

    public function setCfu(int $cfu): static
    {
        $this->cfu = $cfu;

        return $this;
    }

    public function isCompletato(): bool
    {
        $esami = $this->getEsami();
        if ($esami->isEmpty()) return false;
        foreach ($esami as $esame) if ($esame->isAccettato()) return true;

        return false;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'codice' => $this->codice,
            'docente' => $this->docente,
            'note' => $this->note,
            'anno_svolgimento' => $this->annoSvolgimento,
            'esami' => array_map(fn($esame) => $esame->toArray(), $this->esami->toArray()),
            'cfu' => $this->cfu
        ];
    }
}
