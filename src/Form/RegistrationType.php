<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,[
                'label'=>'Votre nom',
                'attr'=>[
                    'placeholder'=>'entrez votre nom',
                ]
            ])
            ->add('lastname', TextType::class,[
                'label'=>'Votre prénom',
                'attr'=>[
                    'placeholder'=>'entrez votre prénom',
                ]
            ])
            ->add('email', EmailType::class,[
                'label'=>'Votre email',
                'attr'=>[
                    'placeholder'=>'entrez votre email',
                ]
            ])
            ->add('password', RepeatedType::class,[
                'type'=>PasswordType::class,
                "constraints"=>new Length(0,8),
                'invalid_message'=>'Le mot de passe et la confirmation doivent etre identiques',
                'label'=>'Mot de passe',
                'required'=>true,
                'first_options'=>[
                    'label'=>'Mot de passe',
                    'attr'=>[
                        'placeholder'=>'entrez votre mot de passe',
                    ]
                ],
                'second_options'=>[
                    'label'=>'Confirmer votre Mot de passe',
                    'attr'=>[
                        'placeholder'=>'confirmer votre mot de passe',
                    ]
                ],
            ])
            ->add('city',TextType::class,[
                'label'=>'Votre Ville',
                'attr'=>[
                    'placeholder'=>'entrez votre ville',
                ]
            ])
            ->add('province',ChoiceType::class,[
                'label'=>'Votre province',
                'choices'=>[
                    'Antananarivo'=>'Antananarivo',
                    'Antsiranana'=>'Antsiranana',
                    'Fianarantsoa'=>'Fianarantsoa',
                    'Mahajanga'=>'Mahajanga',
                    'Toamasina'=>'Toamasina',
                    'Toliara'=>'Toliara',
                ]
            ])
            ->add('phone',TextType::class,[
                'label'=>'Votre numéro de téléphone',
                'attr'=>[
                    'placeholder'=>'entrez votre numéro de téléphone',
                ]
            ])
            ->add('genre',ChoiceType::class,[
                'label'=>'Votre Sexe',
                'choices'=>[
                    'Masculin'=>"M",
                    'Feminin'=>"F",
                ],
                
            ])
            ->add('submit', SubmitType::class,[
                'label'=>'Enregistrer',
                'attr'=>[
                    'class'=>'submit',
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
