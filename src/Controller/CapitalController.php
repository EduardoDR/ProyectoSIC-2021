<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CapitalController extends AbstractController
{
    /**
     * @Route("/capital", name="capital")
     */

    public function index(): Response
    {
        $capital = self::ejecutarQuery("SELECT nombre, debe, haber
	FROM public.ajustes WHERE nombre='CAPITAL';");
        $saldo = self::obtenerSaldoCuenta("CAPITAL");

        return $this->render('capital/index.html.twig', [
            'capital' => $capital,
            'saldo' => $saldo
        ]);
    }

    public function ejecutarQuery(string $query){
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $resultado=$stmt->fetchAll();
        return $resultado;
    }

    public function obtenerSaldoCuenta(string $cuenta){
        $query = "SELECT SUM(debe - haber) as Saldo FROM ajustes WHERE ajustes.nombre='$cuenta'";
        $em = $this->getDOctrine()->getManager();
        $db = $em->getConnection();
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $valor = $stmt->fetchAll();
        return doubleval($valor[0]["saldo"]);

    }
}
