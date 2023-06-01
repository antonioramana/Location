<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/moncompte/car')]
class CarController extends AbstractController
{
    #[Route('/new', name: 'app_car_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarRepository $carRepository): Response
    {
        $car = new Car();
        $user = $this->getUser();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image   = $form->get('image')->getData();
            $fichier = md5(uniqid()).'.'. $image->guessExtension();
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            $car->setImage($fichier);
            $car->setUser($user);
            $car->setCreatedAt(new \DateTime("now"));
            $carRepository->save($car, true);
            $this->addFlash("success","Voiture enregistrée");
            return $this->redirectToRoute('app_mesvoitures', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/new.html.twig', [
            'car' => $car,
            'form' => $form,
            'title' => "Nouvelle voiture",
        ]);
    }

    #[Route('/{id}', name: 'app_car_show', methods: ['GET'])]
    public function show(Car $car): Response
    {
        return $this->render('car/show.html.twig', [
            'car' => $car,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_car_edit', methods: ['GET', 'POST'])]
    public function edit($id,Request $request, Car $car, CarRepository $carRepository): Response
    {
        $user = $this->getUser();
        $car=$carRepository->findOneById($id);
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($user===$car->getUser() && $form->isSubmitted() && $form->isValid()) {
            $carRepository->save($car, true);
            $this->addFlash("success","Voiture modifiée");
            return $this->redirectToRoute('app_mesvoitures', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
            'title' => "Modifier une voiture",
        ]);
    }

    #[Route('/remove/{id}', name: 'app_car_delete', methods: ['GET','POST'])]
    public function delete($id,Request $request, Car $car, CarRepository $carRepository): Response
    {
        $user = $this->getUser();
        $car=$carRepository->findOneById($id);
        if ( $user===$car->getUser() ) {
                $carRepository->remove($car, true);
        }

        $this->addFlash("danger","Voiture supprimée");
        return $this->redirectToRoute('app_mesvoitures', [], Response::HTTP_SEE_OTHER);
    }

}
