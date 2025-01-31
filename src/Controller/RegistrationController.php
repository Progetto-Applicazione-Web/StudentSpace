<?php

namespace App\Controller;

use App\Entity\Studente;
use App\Entity\Utente;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED')) return $this->redirectToRoute('app_home'); // Se loggato lo riporto alla home non puo' registrarsi da loggato :)

        $user = new Utente();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            $student = new Studente();
            $studentName = $form->get('name')->getData();
            $studentSurame = $form->get('surname')->getData();

            $student->setNome($studentName);
            $student->setCognome($studentSurame);
            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setStudente($student);
            $user->addRole('UTENTE');
            $user->addRole('STUDENTE');
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('pages/register/index.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
