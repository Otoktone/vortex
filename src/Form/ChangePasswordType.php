<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Old password',
                'attr' => [
                    'placeholder' => 'Your current paswword',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your current password.',
                    ]),
                ],
            ])
            ->add('newPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Passwords do not match.',
                'first_options' => [
                    'label' => 'New password',
                    'attr' => [
                        'placeholder' => 'New password',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirm your new password',
                    'attr' => [
                        'placeholder' => 'Confirm your new password',
                    ],
                ],
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your new password.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
