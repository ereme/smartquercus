<?php

namespace App\Form;

use App\Entity\Equipo;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')
            ->add('nombre')
            ->add('capacidad')
            ->add('roma')
            ->add('bastidor')
            ->add('fechaAdquisicion', DateType::class, array(
               'label' => 'Fecha de adquisición',
               'widget' => 'single_text',
               'html5' => true,
            ))
            ->add('fechaUltimaInspeccion', DateType::class, array(
               'label' => 'Fecha última inspección',
               'widget' => 'single_text',
               'html5' => true,
            ))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-primary float-right'),
                'label' => 'Guardar'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipo::class,
        ]);
    }
}
