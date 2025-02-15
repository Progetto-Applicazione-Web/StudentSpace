<?php

namespace App\Form;

use App\Entity\Corso;
use App\Entity\StatoCorso;
use App\Entity\Studente;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CorsoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome')
            ->add('codice')
            ->add('docente')
            ->add('note')
            ->add('annoSvolgimento')
            ->add('cfu')
            ->add('studente', EntityType::class, [
                'class' => Studente::class,
                'choice_label' => 'id',
            ])
            ->add('stato', EntityType::class, [
                'class' => StatoCorso::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Corso::class,
        ]);
    }
}
