<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SetPasswordController extends AbstractController
{
    #[Route('moncompte/password', name: 'app_set_password')]
    public function index(Request $request,UserRepository $userRepository,EntityManagerInterface $manager,UserPasswordHasherInterface $UserPasswordHasher): Response
    {
        $form=$this->createFormBuilder()
        
        ->add('old_password',PasswordType::class,[
            'label'=>"Mot de passe actuel : ",    
            'mapped'=>false,
            "attr"=>[
                "class" =>"form-control",
                ]
                ])
         ->add('new_password', RepeatedType::class,[
                    'type'=>PasswordType::class,
                    "constraints"=>new Length(0,8),
                    'invalid_message'=>'Le mot de passe et la confirmation doivent etre identiques',
                    'label'=>'Mot de passe',
                    'required'=>true,
                    'mapped'=>false,
                    'first_options'=>[
                        'label'=>'Nouveau mot de passe',
                        'attr'=>[
                            'placeholder'=>'entrez votre nouveau mot de passe : ',
                            "class" =>"form-control",
                        ]
                    ],
                    'second_options'=>[
                        'label'=>'Confirmer votre nouveau mot de passe : ',
                        'attr'=>[
                            'placeholder'=>'confirmer votre nouveau mot de passe',
                            "class" =>"form-control",
                        ]
                    ],
                ])
                ->add('submit', SubmitType::class,[
                    'label'=>'Mettre à jour',
                    'attr'=>[
                        'class'=>'btn btn-danger m-2',
                    ],
                ]) 

            ->getForm();


         $user = new User();
         $user = $this->getUser();
         $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $old_password=$form->get("old_password")->getData();
                    if($UserPasswordHasher->isPasswordValid($user, $old_password)){
                        $new_password=$form->get("new_password")->getData();
                        $password = $UserPasswordHasher->hashPassword($user, $new_password);
                        $user->setPassword($password);
                        $manager->flush();
                        $this->addFlash("success","Modification avec succès");
                    }else{
                        $this->addFlash("danger","Mauvais mot de passe");
                    }
                //$data=$form->getData();
            }

        return $this->render('set_password/index.html.twig', [
            'title' => 'Modifier le mot de passe',
            'form'=>$form->createView(),
        ]);
    }
}
