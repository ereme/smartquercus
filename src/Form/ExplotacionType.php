<?php

namespace App\Form;

use App\Entity\Explotacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ExplotacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rexa')
            ->add('roppi')
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-primary float-right'),
                'label' => 'Guardar'
            ))            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Explotacion::class,
        ]);
    }
}
