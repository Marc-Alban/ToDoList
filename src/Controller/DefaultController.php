<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(UserRepository $userRepository): Response
    {

        return $this->render('default/index.html.twig', ['user'=>$userRepository->findBy(['id'=>$this->getUser()->getId()])]);
    }
}
