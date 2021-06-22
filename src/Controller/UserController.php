<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user_list")
     */
    public function listAction(UserRepository $userRepository): Response
    {
        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('user/list.html.twig', ['users' => $userRepository->findAll()]);
        }
        return $this->redirectToRoute('homepage');
    }


    /**
     * @Route("/users/create", name="user_create")
     */
    public function createAction(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $manager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $user->setRoles($user->getRoles());
                $user->setPassword($encoder->hashPassword($user, $user->getPassword()));
                $manager->persist($user);
                $manager->flush();
            $this->addFlash('success', "The user has been added successfully.");
            return $this->redirectToRoute('homepage');
        }
        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function editAction(User $user, Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $manager): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setRoles($user->getRoles());
                $password = $encoder->hashPassword($user, $user->getPassword());
                $user->setPassword($password);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', "The user has been modified"); 
            }
            return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
        }
        return $this->redirectToRoute('homepage');
 
    }
}
