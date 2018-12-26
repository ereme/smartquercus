<?php

// src/Form/UserType.php
namespace App\Form;

use App\Entity\Vecino;
use App\Entity\Ayuntamiento;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class VecinoType extends AbstractType
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
            ->add('nombre')
            ->add('apellido1', TextType::class, array(
                'label' => 'Primer apellido'
            ))
            ->add('apellido2', TextType::class, array(
                'label' => 'Segundo apellido'
            ))
            ->add('vatid', TextType::class, array (
                'label' => 'NIF',
            ))
            ->add('ayuntamiento', EntityType::class, array(
                'class' => Ayuntamiento::class,
                'choice_label' => 'localidad',
            )); 
          
            if ($options['data']->getNombre() == null) { //new
                $boton = 'Darme de alta';
            } else { //edit
                $boton = 'Guardar';
                $builder->add('fichero', FileType::class, array(
                    'label' => 'Imagen',
                    'mapped' => false,
                    'required' => false
                ));
            }

            $builder->add('save', SubmitType::class, array(
               'attr' => array('class' => 'btn btn-primary float-right'),
               'label' => $boton
           ))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Vecino::class,
            'fichero' => null
        ));
    }
}