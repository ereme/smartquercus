<?php

// src/Form/UserType.php
namespace App\Form;

use App\Entity\Ayuntamiento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AyuntamientoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Contraseña'),
                'second_options' => array('label' => 'Confirmar contraseña'),
            ))
            ->add('localidad')
            ->add('save', SubmitType::class, array(
               'attr' => array('class' => 'btn btn-primary float-right'),
               'label' => 'Darme de alta'
           ))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ayuntamiento::class,
        ));
    }
}