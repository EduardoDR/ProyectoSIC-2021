<?php

namespace App\Controller;
use App\Repository\PartidaRepository;
use App\Repository\CuentaParcialRepository;
use App\Entity\CuentaParcial;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


class CuentasController extends AbstractController
{
    /**
     * @Route("/cuentas/{id}", name="cuentas")
     */
    public function index($id): Response
    {        
        return $this->render('cuentas/index.html.twig', [
            'controller_name' => 'CuentasController',
            'partidaId' => $id,
           
        ]);
    }
    /**
     * @Route("/registrarCuentas", options = { "expose" = true }, name="registrarCuentas")
     */
    public function registarCuentas(Request $request, LoggerInterface $logger){
        if($request->isXmlHttpRequest()){
            //$conn = $this->getEntityManager()->getConnection();
            $conn = $this->getDoctrine()->getManager();
            $sql = 'INSERT INTO cuenta_parcial (partidas_id,numero,nombre,debe,haber) VALUES ';
            $cuentas= $request->request->get('cuentas');
            $partidaId =$request->request->get('partidaId');
           
           
           for ($i=0; $i < count($cuentas) ; $i++) { 
                $cuentaA = $cuentas[$i];
                $logger->info($cuentaA["nombre"]);
                $nombre = strval( $cuentaA["nombre"]);
                $debe = strval( $cuentaA["debe"]);
                $haber = strval( $cuentaA["haber"]);
                $numeroDeCuenta = strval( $cuentaA["numeroDeCuenta"]);
                
                $sql = $sql . "( $partidaId ,  '$numeroDeCuenta' , '$nombre' , $debe , $haber)";
                if($i != count($cuentas)-1){
                    
                    $sql = $sql . ",";
                }
                
            }
            $logger->info($sql);
           $stmt = $conn->getConnection()->prepare($sql);
           $stmt->execute();
            
            return new JsonResponse(['cuentas' => $cuentas,'partidaId' => $partidaId ]);
        }
        else{
            throw new Exception("Error Processing Request", 1);
        }
    } 
    /**
     * @Route("/catalogoDeCuentas", options = { "expose" = true }, name="catalogoDeCuentas")
     */     
    public function catalogoAll(Request $request){
        if($request->isXmlHttpRequest()){
        $catalogo;
        $conn = $this->getDoctrine()->getManager();
        $sql = 'SELECT * FROM catalogo_de_cuentas';
        $stmt = $conn->getConnection()->prepare($sql);
        $stmt->execute();
        $catalogo = $stmt->fetchAllAssociative();
        return new JsonResponse(['catalogo' =>$catalogo]);
        }
        return "Nada que ver aca";
    }
}
