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

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Corso::class);

        $this->security = $security;
    }

    public function getCorsoById(int $id)
    {
        $studente = $this->getEntityManager()->getRepository(Utente::class)->getUtenteByUsername($this->security->getUser()->getUserIdentifier())->getStudente();
        if ($studente == null ) return null;

        return $this->findOneBy(['id' => $id, 'studente' => $studente]);
    }
}
