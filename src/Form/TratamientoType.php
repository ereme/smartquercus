<?php

namespace App\Form;

use App\Entity\Tratamiento;
use App\Entity\Parcela;
use App\Entity\Plaga;
use App\Entity\Equipo;
use App\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TratamientoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parcelas', EntityType::class, array(
                'choice_label' => function($parcela, $key, $value) {
                    return $parcela->getNumid() .' - '.$parcela->getLocalidad()->getNombre()
                            .' ('.$parcela->getLocalidad()->getProvincia()->getNombre().')'
                            .' - '.$parcela->getSuperficie() .'ha'
                            .' - '.$parcela->getSigpacUso()->getNombre()
                            .' - '.($parcela->getPi() ? 'PI' : 'No PI' );
                },
                'choice_attr' => function($parcela, $key, $value) {
                    return ['class' => 'category_'.strtolower($parcela->getSuperficie())];
                },
                'group_by' => function($parcela, $key, $value) {
                    return 'Agrupación de parcelas '.$parcela->getAgrupacion()->getNombre();
                },
                'label' => 'Parcela/s',
                'class' => Parcela::class,
                'multiple' => true,
                'expanded' => true,
            ))   
            ->add('plaga', EntityType::class, array(
                'choice_label' => 'nombre',
                'label' => 'Plaga',
                'class' => Plaga::class,
            ))            
            ->add('equipo', EntityType::class, array(
                'choice_label' => 'nombre',
                'label' => 'Equipo',
                'class' => Equipo::class,
            ))         
            ->add('producto', EntityType::class, array(
                'choice_label' => 'nombre',
                'label' => 'Producto',
                'class' => Producto::class,
            ))                            
            ->add('registro')
            ->add('dosisRecomendada')
            ->add('unidades')
            ->add('numAplicaciones')
            ->add('dosisEmpleada')
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-primary float-right'),
                'label' => 'Guardar'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tratamiento::class,
        ]);
    }
}
