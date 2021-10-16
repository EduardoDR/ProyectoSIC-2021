<?php

namespace App\Controller;

use App\Entity\Partida;
//use App\Entity\CuentaParcial;
use App\Form\TipoPartidaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class RegistrarController extends AbstractController
{
    /**
     * @Route("/registrar", name="registrar")
     */
    public function index(Request $request): Response
    {
        $id;
        $partida = new Partida();
        $form = $this->createForm(TipoPartidaType::class, $partida);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($partida);
            $em->flush();
            $id = $partida->getId();
            $url = "cuentas/" . $id; //redirige a cuentas/ para agregar sus cuentas parciales
            return $this->redirect($url);
        }

        return $this->render('registrar/index.html.twig', [
            'controller_name' => 'RegistrarController',
            'form' => $form->createView(),
        ]);
    }
  
}
