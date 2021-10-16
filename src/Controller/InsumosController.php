<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class InsumosController extends AbstractController
{
    /**
     * @Route("/costes", name="costes")
     */
    public function index(): Response
    {      
        return $this->render('insumos/index.html.twig', [
            'controller_name' => 'InsumosController'
            
        ]);
    }
    /**
     * @Route("/obtenerInsumos", options = { "expose" = true }, name="obtenerinsumos")
     */
    public function obtnerInsumos(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $insumos;
            $conn = $this->getDoctrine()->getManager();
            $sql = 'SELECT * FROM insumos';
            $stmt = $conn->getConnection()->prepare($sql);
            $stmt->execute();
            $insumos = $stmt->fetchAllAssociative();
            return new JsonResponse(['insumos' =>$insumos]);
        }
       else{

       }
    }

     /**
     * @Route("/guardarCostes", options = { "expose" = true }, name="guardarCostes")
     */
    public function guardarCostes(Request $request)
    {
        if($request->isXmlHttpRequest()){
           
    //estos son los costos por cada tabla, en costos.js linea 176 a 190 esta definida la estructura de este array JSON
            $costos= $request->request->get('costos'); 
    /*--------------------------------------------------------------------------------------------------------------*/        
            $conn = $this->getDoctrine()->getManager();
            $sql = 'SELECT * FROM insumos';



            $stmt = $conn->getConnection()->prepare($sql);
            $stmt->execute();
           
          $message= "ok";
        }
        else{
            $message = "error";
        }
        return new JsonResponse(['status' =>$message]); //para saber si se guardo con exito o no
        
    }
    
}
