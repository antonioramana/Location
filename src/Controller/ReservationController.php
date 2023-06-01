<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Car;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('moncompte/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/new/{car_id}', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new($car_id,Request $request, ReservationRepository $reservationRepository,CarRepository $carRepository): Response
    {
        $reservation = new Reservation();
        $car = new Car();
        $car=$carRepository->find($car_id);
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $reservation->setUser($user);
            $reservation->setCar($car);
            $reservationRepository->save($reservation, true);
            $this->addFlash("success","Votre reservation a été bien effectuée");
           // return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }
}
