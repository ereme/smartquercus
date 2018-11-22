<?php

namespace App\Form;

use App\Entity\Plaga;
use App\Entity\Cultivo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlagaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('cultivos', EntityType::class, array(
                'choice_label' => 'nombre',
                'label' => 'Variedad',
                'class' => Cultivo::class,
                'multiple' => true,
            )) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plaga::class,
        ]);
    }
}
