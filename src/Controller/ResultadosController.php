<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultadosController extends AbstractController
{
    /**
     * @Route("/resultados", name="resultados")
     */
    public function index(): Response
    {
        $ingresosPorServicios = self::obtenerSaldoCuenta("INGRESOS POR SERVICIOS");
        $ventaDeAccesorios = self::obtenerSaldoCuenta("VENTA DE ACCESORIOS CONSUMIBLES");
        $ventaDeSoftware = self::obtenerSaldoCuenta("VENTA DE SOFTWARE");
        $costosPorServicios = self::obtenerSaldoCuenta("COSTOS POR SERVICIOS");


        $inventario = self::obtenerSaldoCuenta("INVENTARIOS");
        $comprasAccesorios = self::obtenerSaldoCuenta("COMPRAS DE ACCESORIOS Y CONSUMIBLES");
        $comprasSoftware = self::obtenerSaldoCuenta("COMPRAS DE SOFTWARE");

        $creditoFiscal = self::obtenerSaldoCuenta("IVA CREDITO FISCAL");
        $debitoFiscal = (-1)*(self::obtenerSaldoCuenta("IVA DÉBITO FISCAL"));
        $iva = $creditoFiscal - $debitoFiscal;
        if ($iva < 0){
            $iva = (-1)*$iva;
        }

        return $this->render('resultados/index.html.twig', [
            'ingresosPorServicios' => $ingresosPorServicios,
            'ventaDeAccesorios'=> $ventaDeAccesorios,
            'ventaDeSoftware' => $ventaDeSoftware,
            'costoPorServicios' => $costosPorServicios,

            'inventario' => $inventario,
            'comprasAccesorios'=> $comprasAccesorios,
            'comprasSoftware'=>$comprasSoftware,

            'iva'=>$iva
        ]);
    }

    public function obtenerID(){
        $query = "SELECT MAX(ID) FROM partida";
        $em = $this->getDOctrine()->getManager();
        $db = $em->getConnection();
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $valor = $stmt->fetchAll();
        return intval($valor[0]["max"]);
    }

    public function ejecutarQuery(string $query){
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        return $stmt;
    }

    public function obtenerSaldoCuenta(string $cuenta){
        $query = "SELECT SUM(debe - haber) as Saldo FROM cuenta_parcial WHERE cuenta_parcial.nombre='$cuenta'";
        $em = $this->getDOctrine()->getManager();
        $db = $em->getConnection();
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $valor = $stmt->fetchAll();
        return doubleval($valor[0]["saldo"]);

    }
}
