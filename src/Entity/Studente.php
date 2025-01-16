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
    private ?string $nome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cognome = null;

    #[ORM\Column(length: 32)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $matricola = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    /**
     * @var Collection<int, TodoList>
     */
    #[ORM\OneToMany(targetEntity: TodoList::class, mappedBy: 'id_studente')]
    private Collection $todoLists;

    /**
     * @var Collection<int, Notifica>
     */
    #[ORM\OneToMany(targetEntity: Notifica::class, mappedBy: 'id_studente', orphanRemoval: true)]
    private Collection $notifiche;

    /**
     * @var Collection<int, Tassa>
     */
    #[ORM\OneToMany(targetEntity: Tassa::class, mappedBy: 'id_studente', orphanRemoval: true)]
    private Collection $tasse;

    public function __construct()
    {
        $this->todoLists = new ArrayCollection();
        $this->notifiche = new ArrayCollection();
        $this->tasse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCognome(): ?string
    {
        return $this->cognome;
    }

    public function setCognome(?string $cognome): static
    {
        $this->cognome = $cognome;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, TodoList>
     */
    public function getTodoLists(): Collection
    {
        return $this->todoLists;
    }

    public function addTodoList(TodoList $todoList): static
    {
        if (!$this->todoLists->contains($todoList)) {
            $this->todoLists->add($todoList);
            $todoList->setIdStudente($this);
        }

        return $this;
    }

    public function removeTodoList(TodoList $todoList): static
    {
        if ($this->todoLists->removeElement($todoList)) {
            // set the owning side to null (unless already changed)
            if ($todoList->getIdStudente() === $this) {
                $todoList->setIdStudente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notifica>
     */
    public function getNotifiche(): Collection
    {
        return $this->notifiche;
    }

    public function addNotifica(Notifica $notifica): static
    {
        if (!$this->notifiche->contains($notifica)) {
            $this->notifiche->add($notifica);
            $notifica->setIdStudente($this);
        }

        return $this;
    }

    public function removeNotifica(Notifica $notifica): static
    {
        if ($this->notifiche->removeElement($notifica)) {
            // set the owning side to null (unless already changed)
            if ($notifica->getIdStudente() === $this) {
                $notifica->setIdStudente(null);
            }
        }

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
            $tassa->setIdStudente($this);
        }

        return $this;
    }

    public function removeTassa(Tassa $tassa): static
    {
        if ($this->tasse->removeElement($tassa)) {
            // set the owning side to null (unless already changed)
            if ($tassa->getIdStudente() === $this) {
                $tassa->setIdStudente(null);
            }
        }

        return $this;
    }
}
