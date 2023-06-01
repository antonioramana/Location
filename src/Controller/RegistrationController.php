<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_registration')]
    public function index(Request $request, EntityManagerInterface $manager,UserPasswordHasherInterface $UserPasswordHasher): Response
    {
        $user=new User();
        $userForm=$this->createForm(RegistrationType::class,$user);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()){
           $user= $userForm->getData();
            $password = $UserPasswordHasher->hashPassword($user, $user->getPassword());
             $user->setPassword($password);
             $manager->persist($user);
             try{
                $manager->flush();
                $this->addFlash("success","Inscription avec succès");
                }finally{
                    return $this->render('registration/index.html.twig', [
                        'controller_name' => 'RegisterController',
                        "userForm" => $userForm->createView(),
                        "title"=>"Karloco-Inscription"
                    ]);
             }
        }

        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegisterController',
            "userForm" => $userForm->createView(),
            "title"=>"Karloco-Inscription"
        ]);
    }
}
