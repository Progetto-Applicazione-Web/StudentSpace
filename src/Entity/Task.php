<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PHPUnit\Util\Exception;
use function PHPUnit\Framework\assertEquals;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $titolo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descrizione = null;

    #[ORM\Column]
    private ?bool $is_completed = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TodoList $todo_id = null;

    #[ORM\OneToOne(targetEntity: self::class, inversedBy: 'parent_task', cascade: ['persist', 'remove'])]
    private ?self $parent_task_id = null;

    #[ORM\OneToOne(targetEntity: self::class, mappedBy: 'parent_task_id', cascade: ['persist', 'remove'])]
    private ?self $parent_task = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitolo(): ?string
    {
        return $this->titolo;
    }

    public function setTitolo(string $titolo): static
    {
        $this->titolo = $titolo;

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

    public function isCompleted(): ?bool
    {
        return $this->is_completed;
    }

    public function setCompleted(bool $is_completed): static
    {
        $this->is_completed = $is_completed;

        return $this;
    }

    public function getTodoId(): ?TodoList
    {
        return $this->todo_id;
    }

    public function setTodoId(?TodoList $todo_id): static
    {
        $this->todo_id = $todo_id;

        return $this;
    }

    public function getParentTaskId(): ?self
    {
        return $this->parent_task_id;
    }

    public function setParentTaskId(?self $parent_task_id): static
    {
        $this->parent_task_id = $parent_task_id;

        return $this;
    }

    public function getParentTask(): ?self
    {
        return $this->parent_task;
    }

    public function setParentTask(?self $parent_task): static
    {
        // TODO: Evitare la ricorsione tra le task
        // parent_task != task
        assertEquals(false, $parent_task === $this, "Task.setParentTask: Il 'Parent Task' non puo' essere uguale alla 'Task'");

        // unset the owning side of the relation if necessary
        if ($parent_task === null && $this->parent_task !== null) {
            $this->parent_task->setParentTaskId(null);
        }

        // set the owning side of the relation if necessary
        if ($parent_task !== null && $parent_task->getParentTaskId() !== $this) {
            $parent_task->setParentTaskId($this);
        }

        $this->parent_task = $parent_task;


        return $this;
    }
}
