<?php

namespace App\Form;

use App\classes\Search;
use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('string',TextType::class,[
                "label"=>"Entrez la marque de voiture",
                "required"=>false,
                "attr"=>[
                    "placeholder"=>"Entrez la marque ou le type de voiture...",
                    "class"=>"form-control",
                ]
            ])
            ->add('type',EntityType::class,[
                "label"=>"Filtrer par type de voiture:",
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
            'data_class' => Search::class,
            'method'=>'GET',
            'crsf_protection'=>false,

        ]);
    }
    public function getBlockPrefix(){
        return '';
    }
}