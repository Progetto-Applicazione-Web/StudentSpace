<?php

namespace App\Repository;

use App\Entity\Corso;
use App\Entity\Studente;
use App\Entity\Utente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<Corso>
 */
class CorsoRepository extends ServiceEntityRepository
{
    private Security $security;
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, Security $security, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Corso::class);

        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function getCorsoById(int $id)
    {
        $studente = $this->entityManager->getRepository(Utente::class)->getUtenteByUsername($this->security->getUser()->getUserIdentifier())->getStudente();
        if ($studente == null ) return null;

        return $this->findOneBy(['id' => $id, 'studente' => $studente]);
    }
}
