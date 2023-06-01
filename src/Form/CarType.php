<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mark',TextareaType::class,[
                'label'=>'Marque et date de sortie',
                "attr"=>[
                "class" =>"form-control",
                ]])
            ->add('tarif', NumberType::class,[
                'label'=>'Tarif par jour ',
                "attr"=>[
                "class" =>"form-control",
                ]])
            ->add('color', TextType::class,[
                'label'=>'Couleur',
                "attr"=>[
                    "class" =>"form-control",
                    ]])
             ->add('nbplace',IntegerType::class,[
                        'label'=>'Nombre de place',
                        "attr"=>[
                            "class" =>"form-control",
                            ]])
             ->add('type',null,[
                                "attr"=>[
                                    "class" =>"form-control",
                                ],
                                ])
            ->add('description',TextareaType::class,[
                                   'label'=>'Description',
                                   "attr"=>[
                                       "class" =>"form-control",
                                       ],
                               ])
            ->add('image', FileType::class,[
                                   "label"=>"Image",
                                   "attr"=>[
                                   "class" =>"form-control",
                                   ],
                                   "label" => false,
                                   "mapped" => false, 
                                   "multiple" => false
                               ])
            ->add('vintage',ChoiceType::class,[
                    'label'=>'Vintage : ',
                    'choices'=>[
                        'Oui'=>true,
                        'Non'=>false,
                    ],
                    'expanded'=>true,
                    'multiple'=>false,
            ])
            ->add('climatisation',ChoiceType::class,[
                'label'=>'Climatisation : ',
                'choices'=>[
                    'Oui'=>true,
                    'Non'=>false,
                ],
               
                'expanded'=>true,
                'multiple'=>false,
            ])
            ->add('decapotable',ChoiceType::class,[
                'label'=>'Décapotable : ',
                'choices'=>[
                    'Oui'=>true,
                    'Non'=>false,
                ],
                'expanded'=>true,
                'multiple'=>false,
            ])
            ->add('toit_ouvrant',ChoiceType::class,[
                'label'=>'Toit ouvrant : ',
                'choices'=>[
                    'Oui'=>true,
                    'Non'=>false,
                ],
                'expanded'=>true,
                'multiple'=>false,
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
