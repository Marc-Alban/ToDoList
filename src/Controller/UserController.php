<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user_list")
     * @IsGranted("ROLE_ADMIN")
     */
    public function listAction(UserRepository $userRepository): Response
    {
        return $this->render('user/list.html.twig', ['users' => $userRepository->findAll()]);
    }


    /**
     * Ajoute l'utilisateur au role sauf pour ROLE_USER qui est automatiquement ajouter
     */
    private function addRoles(User $user,EntityManagerInterface $manager): void
    {
        if($this->isGranted("ROLE_ADMIN"))
            foreach ($user->getRoles() as $role){
                dd($role);
                // if($role->getTitle() !== "ROLE_USER"){
                //     $role->addUser($user);
                //     $manager->persist($role);
                // }
            }
    }

    /**
     * @Route("/users/create", name="user_create")
     */
    public function createAction(Request $request,UserPasswordHasher $encoder,EntityManagerInterface $manager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //seul les admins peuvent changer le role d'un utilisateur
            if($this->isGranted("ROLE_ADMIN"))
                $this->addRoles($user,$manager);
            $user->setPassword($encoder->hashPassword($user,$user->getPassword()));
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/users/{id}/edit", name="user_edit")
     * @Security ("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function editAction(User $user, Request $request,UserPasswordHasher $encoder,EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $roles = $user->getRoles();
        dd($roles);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Role $role */
            foreach ($roles as $role){
                    $role->removeUser($user);
                    $manager->persist($role);
            }
            $this->addRoles($user,$manager);

            $password = $encoder->hashPassword($user,$user->getPassword());
            $user->setPassword($password);
            $manager->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");
            if($this->isGranted('ROLE_ADMIN'))
                return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}