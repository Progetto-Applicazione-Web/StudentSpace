<?php

namespace App\Repository;

use App\Entity\TodoList;
use App\Entity\Utente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<TodoList>
 */
class TodoListRepository extends ServiceEntityRepository
{
    private Security $security;
    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, TodoList::class);
        $this->security = $security;
    }

    public function getTodoListById(int $id): ?TodoList
    {
        $studente = $this->getEntityManager()->getRepository(Utente::class)->getUtenteByUsername($this->security->getUser()->getUserIdentifier())->getStudente();
        if ($studente == null ) return null;

        return $this->findOneBy(['id' => $id, 'studente' => $studente]);
    }
}
