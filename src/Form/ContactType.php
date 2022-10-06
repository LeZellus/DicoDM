<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label_attr'=> ['class' => 'hidden'],
                'attr' => ['placeholder' => 'Nom et Prénom', 'class' => 'form-input rounded-t-md'],
            ])
            ->add('email', EmailType::class, [
                'label_attr'=> ['class' => 'hidden'],
                'attr' => ['placeholder' => 'Email de contact...', 'class' => 'form-input'],
            ])
            ->add('message', TextareaType::class, [
                'label_attr'=> ['class' => 'hidden'],
                'attr' => ['placeholder' => 'Je te contacte pour ...', 'class' => 'form-input form-textarea rounded-b-md'],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'form-button'],
                'label' => 'Envoyer le message'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
