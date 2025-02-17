<?php

namespace App\Entity;

use App\Repository\StudenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudenteRepository::class)]
class Studente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $matricola = null;

    #[ORM\Column(nullable: true)]
    private ?int $stuId = null;

    #[ORM\Column(nullable: true)]
    private ?int $matId = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $cognome = null;

    #[ORM\OneToOne(inversedBy: 'studente', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utente $user = null;

    /**
     * @var Collection<int, Tassa>
     */
    #[ORM\OneToMany(targetEntity: Tassa::class, mappedBy: 'studente')]
    private Collection $tasse;

    /**
     * @var Collection<int, Esame>
     */
    #[ORM\OneToMany(targetEntity: Esame::class, mappedBy: 'studente')]
    private Collection $esami;

    /**
     * @var Collection<int, Corso>
     */
    #[ORM\OneToMany(targetEntity: Corso::class, mappedBy: 'studente')]
    private Collection $corsi;

    /**
     * @var Collection<int, TodoList>
     */
    #[ORM\OneToMany(targetEntity: TodoList::class, mappedBy: 'studente', cascade: ['persist', 'remove'])]
    private Collection $todolists;

    public function __construct()
    {
        $this->tasse = new ArrayCollection();
        $this->esami = new ArrayCollection();
        $this->corsi = new ArrayCollection();
        $this->todolists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricola(): ?string
    {
        return $this->matricola;
    }

    public function setMatricola(string $matricola): static
    {
        $this->matricola = $matricola;

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

    public function getCognome(): ?string
    {
        return $this->cognome;
    }

    public function setCognome(string $cognome): static
    {
        $this->cognome = $cognome;

        return $this;
    }

    public function getUser(): ?Utente
    {
        return $this->user;
    }

    public function setUser(Utente $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Tassa>
     */
    public function getTasse(): Collection
    {
        return $this->tasse;
    }

    public function addTassa(Tassa $tassa): static
    {
        if (!$this->tasse->contains($tassa)) {
            $this->tasse->add($tassa);
            $tassa->setStudente($this);
        }

        return $this;
    }

    public function removeTassa(Tassa $tassa): static
    {
        if ($this->tasse->removeElement($tassa)) {
            // set the owning side to null (unless already changed)
            if ($tassa->getStudente() === $this) {
                $tassa->setStudente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Esame>
     */
    public function getEsami(): Collection
    {
        return $this->esami;
    }

    public function addEsame(Esame $esame): static
    {
        if (!$this->esami->contains($esame)) {
            $this->esami->add($esame);
            $esame->setStudente($this);
        }

        return $this;
    }

    public function removeEsame(Esame $esame): static
    {
        if ($this->esami->removeElement($esame)) {
            // set the owning side to null (unless already changed)
            if ($esame->getStudente() === $this) {
                $esame->setStudente(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Corso>
     */
    public function getCorsi(): Collection
    {
        return $this->corsi;
    }

    public function addCorso(Corso $corso): static
    {
        if (!$this->corsi->contains($corso)) {
            $this->corsi->add($corso);
            $corso->setStudente($this);
        }
        return $this;
    }

    public function removeCorso(Corso $corso): static
    {
        if ($this->corsi->removeElement($corso)) {
            // set the owning side to null (unless already changed)
            if ($corso->getStudente() === $this) {
                $corso->setStudente(null);
            }
        }
        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'matricola' => $this->matricola,
            'nome' => $this->nome,
            'cognome' => $this->cognome,
            'user' => $this->user->toArray(),
            'tasse' => array_map(fn($tassa) => $tassa->toArray(), $this->tasse->toArray()),
            'esami' => array_map(fn($esame) => $esame->toArray(), $this->esami->toArray()),
            'corsi' => "",//array_map(fn($corso) => $corso->toArray(), $this->corsi->toArray())
        ];
    }

    /**
     * @return Collection<int, TodoList>
     */
    public function getTodolists(): Collection
    {
        return $this->todolists;
    }

    public function addTodolist(TodoList $todolist): static
    {
        if (!$this->todolists->contains($todolist)) {
            $this->todolists->add($todolist);
            $todolist->setStudente($this);
        }

        return $this;
    }

    public function removeTodolist(TodoList $todolist): static
    {
        if ($this->todolists->removeElement($todolist)) {
            // set the owning side to null (unless already changed)
            if ($todolist->getStudente() === $this) {
                $todolist->setStudente(null);
            }
        }

        return $this;
    }
}
