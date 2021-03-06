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
     *
     * @param UserRepository $userRepository
     * @return Response
     */
    public function listAction(UserRepository $userRepository): Response
    {
        $user = $userRepository->findById($this->getUser()->getId());
        $this->denyAccessUnlessGranted('USER_READ', $user[0]);
        return $this->render('user/list.html.twig', ['users' => $userRepository->findAll()]);
    }


    /**
     * @Route("/users/create", name="user_create")
     *
     * @param Request $request
     * @param UserPasswordHasherInterface $encoder
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function createAction(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $manager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                if(empty($form->getViewData()->getRoles())){
                    $user->setRoles(['ROLE_USER']);
                }          
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
     *
     * @param User $user
     * @param Request $request
     * @param UserPasswordHasherInterface $encoder
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function editAction(User $user, Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('USER_EDIT', $user);

        if ($this->isGranted('ROLE_ADMIN') || $user->getId() === $this->getUser()->getId()) {
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
        }
        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }

    /**
     * @Route("/users/{id}/delete", name="user_delete")
     *
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function deleteAction(User $user, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('USER_DELETE', $user);
        $manager->remove($user);
        $manager->flush();
        $this->addFlash('success', 'The user has been removed.');
        return $this->redirectToRoute('user_list');
    }
}
