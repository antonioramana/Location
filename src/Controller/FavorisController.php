<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Entity\Car;
use App\Form\FavorisType;
use App\Repository\FavorisRepository;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('moncompte/favoris')]
class FavorisController extends AbstractController
{
    #[Route('/', name: 'app_favoris_index', methods: ['GET'])]
    public function index(FavorisRepository $favorisRepository): Response
    {
        $user = $this->getUser();
        $fav= $user->getFavoris();
        //$fav= $favorisRepository->findByUser($user);
        dd($fav);
        return $this->render('favoris/index.html.twig', [
            'favoris' =>$fav,
        ]);
    }

    #[Route('/new/{car_id}', name: 'app_favoris_new', methods: ['GET'])]
    public function new($car_id,Request $request, FavorisRepository $favorisRepository,EntityManagerInterface $manager,CarRepository $carRepository): Response
    {
        $favoris= new Favoris();
        $user = $this->getUser();
        $car=new Car;
        $car=$carRepository->find($car_id);
        $favoris->setUser($user); 
        $favoris->setCar($car);  
        $manager->persist($favoris);
        $manager->flush();

        return $this->redirectToRoute('app_allcars', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_favoris_show', methods: ['GET'])]
    public function show(Favoris $favori): Response
    {
        return $this->render('favoris/show.html.twig', [
            'favori' => $favori,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_favoris_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Favoris $favori, FavorisRepository $favorisRepository): Response
    {
        $form = $this->createForm(FavorisType::class, $favori);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $favorisRepository->save($favori, true);

            return $this->redirectToRoute('app_favoris_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('favoris/edit.html.twig', [
            'favori' => $favori,
            'form' => $form,
        ]);
    }

    // #[Route('/remove/{car_id}', name: 'app_favoris_delete', methods: ['GET','POST'])]
    // public function delete(Request $request, Favoris $favori, FavorisRepository $favorisRepository,CarRepository $carsRepository): Response
    // {
       
    //     $car=$carsRepository->findOneByCar($id);
    //     $favori=$favorisRepository->findOneByCar($car);         
        
    //      $favorisRepository->remove($favori, true);
        
    //     return $this->redirectToRoute('app_allcars', [], Response::HTTP_SEE_OTHER);
    // }
}
