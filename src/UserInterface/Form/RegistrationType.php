<?php

namespace App\UserInterface\Form;

use App\Infrastructure\Validator\NonUniqueEmail;
use App\Infrastructure\Validator\NonUniquePseudo;
use App\UserInterface\DataTRansferObject\RegistrationDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstname',
                TextType::class,
                [
                    'label'       => 'FisrtName :',
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    'label'       => 'LastName :',
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            )
            ->add(
                'pseudo',
                TextType::class,
                [
                    'label'       => 'Pseudo :',
                    'constraints' => [
                        new NotBlank(),
                        new NonUniquePseudo()
                    ],
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label'       => 'Email :',
                    'constraints' => [
                        new NotBlank(),
                        new Email(),
                        new NonUniqueEmail()
                    ],
                ]
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type'            => PasswordType::class,
                    'first_options'   => [
                        'label' => 'Password :',
                    ],
                    'second_options'  => [
                        'label' => 'Retaped password :',
                    ],
                    'invalid_message' => 'The password confirmation must be similar to the password.',
                    'constraints'     => [
                        new NotBlank(),
                        new Length(['min' => 8]),
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => RegistrationDTO::class,
            ]
        );
    }
}
