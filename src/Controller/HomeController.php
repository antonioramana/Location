<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Car;
use App\Repository\CarRepository;
use App\classes\Search;
use App\Form\SearchType;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CarRepository $carRepository): Response
    {
        $cars=new Car();
        $cars=$carRepository->findBy(array(),array("createdAt"=>"DESC"),6,0);
    
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'cars' => $cars,
        ]);
    }
    #[Route('/voitures', name: 'app_allcars')]
    public function allcar(Request $request,CarRepository $repository): Response
    {
        $search=new Search();
        $cars=new Car();
        $cars=$repository->findBy(array(),array("createdAt"=>"DESC"));
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cars=$repository->findWidthSearch($search);
        }

        return $this->render('home/cars.html.twig', [
             'cars' => $cars,
             "form"=>$form->createView()
        ]);
    }
}
