<?php

namespace App\Form;

use App\Entity\Parcela;
use App\Entity\Localidad;
use App\Entity\Agrupacion;
use App\Entity\Cultivo;
use App\Entity\Variedad;
use App\Entity\SigpacUso;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParcelaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numid')
            ->add('poligono')
            ->add('parcela')
            ->add('recinto')
            ->add('superficie')
            ->add('volumencopa')
            ->add('pi')
            ->add('piayuda')
            ->add('marcoPlantacion')
            ->add('agrupacion', EntityType::class, array(
                'choice_label' => 'nombre',
                'label' => 'Agrupacion',
                'class' => Agrupacion::class,
            ))
            ->add('localidad', EntityType::class, array(
                'choice_label' => 'nombre',
                'label' => 'Localidad',
                'class' => Localidad::class,
            ))
            ->add('variedades', EntityType::class, array(
                'choice_label' => 'nombre',
                'label' => 'Variedad',
                'class' => Variedad::class,
                'multiple' => true,
            ))            
            ->add('sigpacUso', EntityType::class, array(
                'choice_label' => 'nombre',
                'label' => 'SIGPAC Uso',
                'class' => SigpacUso::class,
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
            'data_class' => Parcela::class,
        ]);
    }
}
