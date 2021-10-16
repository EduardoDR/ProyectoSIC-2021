<?php

namespace App\Controller;

use App\Entity\CuentaParcial;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibroMayorController extends AbstractController
{
    /**
     * @Route("/mayor", name="libro_mayor")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = "SELECT DISTINCT nombre from cuenta_parcial";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);

        $numerosDeCuenta = $stmt->fetchAll();

        $cuentas = array();
        $saldos = array();
        $nombresDeCuenta = array();

        if (is_array($numerosDeCuenta) || is_object($numerosDeCuenta)){
            foreach ( $numerosDeCuenta as $numero ){
                foreach ($numero as $valor) {
                    $numString = strval($valor);
                    $query2 = "SELECT partida.fecha, partida.concepto, cuenta_parcial.debe, cuenta_parcial.haber
        FROM cuenta_parcial
        INNER JOIN partida ON cuenta_parcial.partidas_id=partida.id WHERE cuenta_parcial.nombre='$numString';";
                    $query3 = "SELECT SUM(debe - haber) as Resta FROM cuenta_parcial WHERE cuenta_parcial.nombre='$numString';
";
                    $stmt2 = $db->prepare($query2);
                    $params2 = array();
                    $stmt2->execute($params2);
                    $stmt3 = $db->prepare($query3);
                    $params3 = array();
                    $stmt3->execute($params3);

                    $saldo = $stmt3->fetchAll();
                    $cuenta = $stmt2->fetchAll();

                    array_push($cuentas, $cuenta);
                    array_push($nombresDeCuenta, $numString);
                    array_push($saldos, $saldo);
                }
            }
        }


        //$cuentas = $stmt->fetchAll();

        return $this->render('libro_mayor/index.html.twig', [
            'cuentas' => $cuentas,
            'numeros' => $numerosDeCuenta,
            'nombres' => $nombresDeCuenta,
            'saldos' => $saldos
        ]);
    }
    /*
    public function sqlNativo(){
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = "SELECT * FROM cuenta_parcial";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);

        $cuentas = $stmt->fetchAll();

        foreach($cuentas as $cuenta){
            each $cuenta["nombre"]."<br/>";
        }

        die();
    }*/
}
