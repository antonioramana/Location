<?php

namespace App\Form;

use App\classes\SearchAdvanced;
use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SearchAdvancedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mark',TextType::class,[
                "label"=>"Entrez la marque ou le type de voiture",
                "required"=>false,
                "attr"=>[
                    "placeholder"=>"Entrez la marque ou le type de voiture...",
                    "class"=>"form-control",
                ]
            ])
            ->add('vintage',ChoiceType::class,[
                'label'=>'Vintage ',
                'choices'=>[
                    'Oui'=>true,
                    'Non'=>false,
                ],
                "attr"=>[
                    "class" =>"form-control",
                    ],
                'expanded'=>true,
                'multiple'=>false,
        ])
        ->add('climatisation',ChoiceType::class,[
            'label'=>'Climatisation',
            'choices'=>[
                'Oui'=>true,
                'Non'=>false,
            ],
            "attr"=>[
                "class" =>"form-control",
                ],
            'expanded'=>true,
            'multiple'=>false,
        ])
        ->add('decapotable',ChoiceType::class,[
            'label'=>'Décapotable',
            'choices'=>[
                'Oui'=>true,
                'Non'=>false,
            ],
            "attr"=>[
                "class" =>"form-control",
                ],
            'expanded'=>true,
            'multiple'=>false,
        ])
        ->add('toit_ouvrant',ChoiceType::class,[
            'label'=>'Toit ouvrant',
            'choices'=>[
                'Oui'=>true,
                'Non'=>false,
            ],
            "attr"=>[
                "class" =>"form-control",
                ],
            'expanded'=>true,
            'multiple'=>false,
         ])
            ->add('type',EntityType::class,[
                "label"=>false,
                "required"=>false,
                "class"=>Type::class,
                "multiple"=>true,
                "expanded"=>true,
                "attr"=>[
                    "class"=>"form-control"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchAdvanced::class,
            'method'=>'GET',
            'crsf_protection'=>false,

        ]);
    }
    public function getBlockPrefix(){
        return '';
    }
}