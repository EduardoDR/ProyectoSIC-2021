<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HHomeController extends AbstractController
{
    /**
     * @Route("/h/home", name="h_home")
     */
    public function index(): Response
    {
        return $this->render('h_home/index.html.twig', [
            'controller_name' => 'HHomeController',
        ]);
    }
}
