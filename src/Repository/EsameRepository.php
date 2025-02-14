<?php

namespace App\Repository;

use App\Entity\Esame;
use App\Entity\Utente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<Esame>
 */
class EsameRepository extends ServiceEntityRepository
{
    private Security $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Esame::class);

        $this->security = $security;
    }

    public function getEsameById(int $id)
    {
        $studente = $this->getEntityManager()->getRepository(Utente::class)->getUtenteByUsername($this->security->getUser()->getUserIdentifier())->getStudente();
        if ($studente == null ) return null;

        return $this->findOneBy(['id' => $id, 'studente' => $studente]);
    }
}
