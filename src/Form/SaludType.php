<?php

namespace App\Form;

use App\Entity\Salud;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\ImagenType;
use Symfony\Component\HttpFoundation\File\File;




class SaludType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('fichero', FileType::class, array(
                'label' => 'Imagen',
                'mapped' => false
            ))
            ->add('texto', TextareaType::class, array(
                'attr' => array('class' => 'tinymce', 
                                'rows'=>'5')
                ))
            ->add('fechahora', DateType::class, array(
                    'label' => 'Fecha',
                    'widget' => 'single_text',
                    'html5' => true,
                    'required' => true
                ))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-primary float-right'),
                'label' => 'Guardar'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salud::class,
            'fichero' => null
        ]);
    }
}
