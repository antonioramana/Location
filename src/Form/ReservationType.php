<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbjour',IntegerType::class,[
                'label'=>'Nombre de jour',
                "attr"=>[
                "class" =>"form-control",
                ]])
            ->add('lieu',TextType::class,[
                'label'=>'Lieu de reservation',
                "attr"=>[
                "class" =>"form-control",
                ]])
            ->add('dateres',DateTimeType::class,[
                'label'=>'Date et heure de reservation',
               ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
