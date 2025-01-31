<?php

namespace App\Repository;

use App\Entity\Esame;
use App\Entity\Studente;
use App\Entity\Utente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<Studente>
 */
class StudenteRepository extends ServiceEntityRepository
{
    private Security $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Studente::class);

        $this->security = $security;
    }
    /*

    {% for esame in app.user.studente.esami %}
				{% if esame.isAccettato %}

     */

    public function getVotiAccepted(): array
    {
        $votiAccettati = [];

        $utente = $this->getEntityManager()->getRepository(Utente::class)->getUtenteByUsername($this->security->getUser()->getUserIdentifier());
        $esami = $this->getEntityManager()->getRepository(Esame::class)->findBy( ['studente' => $utente->getStudente()]);

        foreach ($esami as $esame) {
            if ($esame->isAccettato()) $votiAccettati[] = $esame->getVoto();
        }

        return $votiAccettati;
    }

    public function getVotiPerMedia(): array
    {
        $votiAccettati = $this->getVotiAccepted();
        $votiPerMedia = array_filter($votiAccettati, 'is_numeric');

        return array_map('intval', $votiPerMedia);
    }

}
