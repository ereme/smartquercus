<?php

namespace App\Form;

use App\Entity\Incidencia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class IncidenciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('latitud', null, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Latitud',
                    'class' => 'form-control'
                )
            ))
            ->add('longitud', null, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Latitud',
                    'class' => 'form-control'
                )
            ))
            ->add('descripcion', TextareaType::class, array(
                'label' => false,
                'attr' => array(
                  'placeholder' => 'Descripción del inmueble',
                  'class' => 'form-control'
                )

            ))
            ->add('estado', ChoiceType::class, array(
                'attr' => array('class' => 'custom-select'),
                'choices' => Incidencia::ESTADOS
            ))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-primary float-right'),
                'label' => 'Guardar'
            ))
            ->add('delete', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-primary float-right'),
                'label' => 'Borrar'
            ))   
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Incidencia::class,
        ]);
    }
}
