<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => false,
            ])
            ->add('username', TextType::class, [
                'required' => false,
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'required' => false,
                'label' => 'Nom'
            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'label' => 'Mot de passe'
            ])
            ->add('confirm_password', PasswordType::class, [
                'label' => 'Confirmer le mot de passe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['registration']
        ]);
    }
}