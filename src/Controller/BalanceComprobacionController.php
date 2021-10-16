<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BalanceComprobacionController extends AbstractController
{
    /**
     * @Route("/balance/comprobacion", name="balance_comprobacion")
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

        $saldos = array();
        $nombresDeCuenta = array();

        if (is_array($numerosDeCuenta) || is_object($numerosDeCuenta)){
            foreach ( $numerosDeCuenta as $numero ){
                foreach ($numero as $valor) {
                    $numString = strval($valor);
                    $query3 = "SELECT SUM(debe - haber) as Resta FROM cuenta_parcial WHERE cuenta_parcial.nombre='$numString';
";
                    $stmt3 = $db->prepare($query3);
                    $params3 = array();
                    $stmt3->execute($params3);

                    $saldo = $stmt3->fetchAll();


                    array_push($nombresDeCuenta, $numString);
                    array_push($saldos, $saldo);
                }
            }
        }

        return $this->render('balance_comprobacion/index.html.twig', [
            'nombres' => $nombresDeCuenta,
            'saldos' => $saldos,
        ]);
    }
}
