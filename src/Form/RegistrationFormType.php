<?php

namespace App\Form;

use App\Entity\Utente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                    'mapped' => false, // Non mappato sull'entità Utente
                    'label' => 'Nome',
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Jason',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Inserisci il tuo nome',
                        ]),
                        new Length([
                            'max' => 255,
                            'maxMessage' => 'Il nome non può superare i {{ limit }} caratteri',
                        ]),
                    ]
                ]
            )
            ->add('surname', TextType::class, [
                    'mapped' => false, // Non mappato sull'entità Utente
                    'label' => 'Cognome',
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Bini',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Inserisci il tuo cognome',
                        ]),
                        new Length([
                            'max' => 255,
                            'maxMessage' => 'Il cognome non può superare i {{ limit }} caratteri',
                        ]),
                    ]
                ]
            )
            ->add('username', TextType::class, [
                    'label' => 'Username',
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'jason.bini',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Inserisci il tuo username',
                        ]),
                        new Length([
                            'max' => 255,
                            'maxMessage' => 'Il username non può superare i {{ limit }} caratteri',
                        ]),
                    ]
                ]
            )
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utente::class,
        ]);
    }
}
