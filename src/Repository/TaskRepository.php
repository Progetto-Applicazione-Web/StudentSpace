<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\Utente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    private Security $security;
    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Task::class);
        $this->security = $security;
    }

    public function getTaskById(int $id): ?Task
    {
        $studente = $this->getEntityManager()->getRepository(Utente::class)->getUtenteByUsername($this->security->getUser()->getUserIdentifier())->getStudente();
        if ($studente == null ) return null;

        $task = $this->findOneBy(['id' => $id]);
        if ($task == null) return null;

        if ($task->getStudente() == $studente) return $task;

        return null;
    }
}
