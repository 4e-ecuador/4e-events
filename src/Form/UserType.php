<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices'  => [
                        'Admin'  => 'ROLE_ADMIN',
                        'Agent' => 'ROLE_AGENT',
                        'User'   => 'ROLE_USER',
                    ]
                    ,
                    'multiple' => true,
                ]
            )
            // ->add('telegram_id')
            ->add('is_verified')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
