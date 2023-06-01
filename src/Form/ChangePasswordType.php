<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label'=>"Email",
                'disabled'=>true,
            ]
            )
            ->add('firstname',TextType::class,[
                'label'=>"Nom",
                'disabled'=>true,
                ])
            ->add('lastname',TextType::class,[
                'label'=>"Prénom",    
                'disabled'=>true,
                    ])
            ->add('old_password',PasswordType::class,[
                'label'=>"Mot de passe actuel",    
                'mapped'=>false,
                    ])
             ->add('new_password', RepeatedType::class,[
                        'type'=>PasswordType::class,
                        "constraints"=>new Length(0,8),
                        'invalid_message'=>'Le mot de passe et la confirmation doivent etre identiques',
                        'label'=>'Mot de passe',
                        'required'=>true,
                        'mapped'=>false,
                        'first_options'=>[
                            'label'=>'Nouveau mot de passe',
                            'attr'=>[
                                'placeholder'=>'entrez votre nouveau mot de passe',
                            ]
                        ],
                        'second_options'=>[
                            'label'=>'Confirmer votre nouveau mot de passe',
                            'attr'=>[
                                'placeholder'=>'confirmer votre nouveau mot de passe',
                            ]
                        ],
                    ])
                    ->add('submit', SubmitType::class,[
                        'label'=>'Mettre à jour',
                        'attr'=>[
                            'class'=>'btn btn-danger',
                        ],
                    ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
