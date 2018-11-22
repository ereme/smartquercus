<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use App\Entity\Agrupacion;
use App\Entity\Explotacion;
use Symfony\Component\Security\Core\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AgrupacionType extends AbstractType
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            /*->add('explotacion', EntityType::class, array(
                'choice_label' => 'roppi',
                'label' => 'Explotacion',
                'class' => Explotacion::class,
            ))*/
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-primary float-right'),
                'label' => 'Guardar'
            ))            
        ;

        
        $user = $this->security->getUser();
        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
            $form = $event->getForm();
            $formOptions = array (
                'class' => Explotacion::class,
                'choice_label' => 'roppi',
                'query_builder' => function (EntityRepository $explotacionRepository) use ($user) {
                    return $explotacionRepository->createQueryBuilder('e')
                                            ->join('e.participaciones','p')
                                            ->join('p.user','u')
                                            ->where('u.id = :user_id')
                                            ->orderBy ('e.id','DESC')
                                            ->setParameter('user_id', $user->getId());
                }

            );
            $form->add('explotacion', EntityType::class, $formOptions);

        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Agrupacion::class,
        ]);
    }
}
