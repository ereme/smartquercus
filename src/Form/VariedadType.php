<?php

namespace App\Form;

use App\Entity\Variedad;
use App\Entity\Cultivo;
use App\Entity\Parcela;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VariedadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('cultivo', EntityType::class, array(
                'choice_label' => 'nombre',
                'label' => 'Cultivo',
                'class' => Cultivo::class,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Variedad::class,
        ]);
    }
}
