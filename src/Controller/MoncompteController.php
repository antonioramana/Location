<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarRepository;
use App\Repository\FavorisRepository;
use App\classes\SearchAdvanced;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Doctrine\ORM\EntityManagerInterface;

#[Route('/moncompte')]
class MoncompteController extends AbstractController
{
    #[Route('/', name: 'app_moncompte')]
    public function index(): Response
    {
        return $this->render('moncompte/index.html.twig', [
            'title' => 'Mon profil',
        ]);
    }

    #[Route('/mesvoitures', name: 'app_mesvoitures')]
    public function mycars(CarRepository $carRepository): Response
    {
        $cars=new Car();
        $cars=$carRepository->findByUser($this->getUser());
        return $this->render('moncompte/mycars.html.twig', [
            'title' => 'Mes voitures',
            'cars' => $cars,
        ]);
    }
    #[Route('/mesfavoris', name: 'app_mesfavoris')]
    public function myfavoris(FavorisRepository $favorisRepository,CarRepository $carsRepository): Response
    {

        $cars=new Car();
        //$cars=$carsRepository->findByUser($this->getUser());
         $favoris=$favorisRepository->findByUser($this->getUser());
         dd($favoris);
        // return $this->render('moncompte/favoris.html.twig', [
        //     'title' => 'Mes favoris',
        //     'cars' => $cars,
        // ]);
    }
    #[Route('/mestransactions', name: 'app_mestransactions')]
    public function mytransactions(): Response
    {
        return $this->render('moncompte/transaction.html.twig', [
            'title' => 'Mes transactions',
        ]);
    }
    #[Route('/recherche', name: 'app_recherche', methods: ['GET', 'POST'])]
    public function findcar(Request $request,EntityManagerInterface $manager,CarRepository $carRepository): Response
    {
        $form=$this->createFormBuilder()
        
        ->add('mark',TextType::class,[
            "label"=>"Entrez la marque de voiture :",
            "required"=>false,
            "attr"=>[
                "placeholder"=>"Entrez la marque ou le type de voiture...",
                "class"=>"form-control my-2",
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
            "class" =>"form-control ",
            ],
        'expanded'=>true,
        'multiple'=>false,
     ])
        ->add('type',EntityType::class,[
            "label"=>"Type de voiture :",
            "required"=>false,
            "class"=>Type::class,
            "multiple"=>true,
            "expanded"=>true,
            "attr"=>[
                "class"=>"form-control my-2"
            ]
        ])
        ->add('submit', SubmitType::class,[
            'label'=>'Rechercher',
            'attr'=>[
                'class'=>'btn btn-custom col-md-12',
            ],
        ]) 
     ->getForm();

        $searchAdvanced=new SearchAdvanced();
        $cars=new Car();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mark=$form->get("mark")->getData();
            $type=$form->get("type")->getData();
            $vintage=$form->get("vintage")->getData();
            $climatisation=$form->get("climatisation")->getData();
            $decapotable=$form->get("decapotable")->getData();
            $toi_ouvrant=$form->get("toit_ouvrant")->getData();
             $cars=$carRepository->findAdvanced($mark,$type,$vintage,$climatisation,$toi_ouvrant,$decapotable);
        }
        return $this->render('moncompte/findcar.html.twig', [
            'title' => 'Recherche',
            'form'=>$form->createView(),
            "cars"=>$cars
        ]);
    }
 } 