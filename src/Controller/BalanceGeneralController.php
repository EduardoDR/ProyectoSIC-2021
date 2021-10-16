<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BalanceGeneralController extends AbstractController
{
    /**
     * @Route("/balance_general", name="balance_general")
     */

    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();

        self::ejecutarQuery("DROP TABLE IF EXISTS ajustes;");
        self::ejecutarQuery("CREATE TABLE ajustes AS TABLE cuenta_parcial;");
        self::ejecutarQuery("DROP TABLE IF EXISTS ajustesPartidas;");
        self::ejecutarQuery("CREATE TABLE ajustesPartidas AS TABLE partida;");
        $id = self::obtenerID();
        $creditoFiscal = self::obtenerSaldoCuenta("IVA CREDITO FISCAL");
        self::ejecutarQuery("INSERT INTO public.ajustespartidas(id, fecha, concepto) VALUES ($id+1,'09-01-2020', 'Por consolidacion de iva');");
        self::ejecutarQuery("INSERT INTO public.ajustes(
	partidas_id, numero, nombre, debe, haber)
	VALUES ($id+1, '1A9', 'IVA CREDITO FISCAL', 0, $creditoFiscal);");
        self::ejecutarQuery("INSERT INTO public.ajustes(
        partidas_id, numero, nombre, debe, haber)
	VALUES ($id+1, '2A7', 'IVA DÉBITO FISCAL', $creditoFiscal, 0);");
        $debitoFiscal = (-1)*(self::obtenerSaldoCuenta("IVA DÉBITO FISCAL"));
        $id = self::obtenerID();
        self::ejecutarQuery("INSERT INTO public.ajustespartidas(id, fecha, concepto) VALUES ($id+1,'09-01-2020', 'Por determinacion de IVA');");
        self::ejecutarQuery("INSERT INTO public.ajustes(
	partidas_id, numero, nombre, debe, haber)
	VALUES ($id+1, '1A9', 'IVA', 0, $debitoFiscal);");
        self::ejecutarQuery("INSERT INTO public.ajustes(
        partidas_id, numero, nombre, debe, haber)
	VALUES ($id+1, '2A7', 'IVA DÉBITO FISCAL', $debitoFiscal, 0);");

        $inventario = (self::obtenerSaldoCuenta("INVENTARIOS"));
        $ingresoPorServicio = (-1)*(self::obtenerSaldoCuenta("INGRESOS POR SERVICIOS"));
        $ventaDeSoftware = (-1)*(self::obtenerSaldoCuenta("VENTA DE SOFTWARE"));
        $ventaDeAccesorios = (-1)*(self::obtenerSaldoCuenta("VENTA DE ACCESORIOS CONSUMIBLES"));
        $costosPorServicios = (self::obtenerSaldoCuenta("COSTOS POR SERVICIOS"));
        $compraAccesorios = (self::obtenerSaldoCuenta("COMPRAS DE ACCESORIOS Y CONSUMIBLES"));
        $compraSoftware = (self::obtenerSaldoCuenta("COMPRAS DE SOFTWARE"));

        $utilidadEjercicio = ($ingresoPorServicio+$ventaDeAccesorios+$ventaDeSoftware)-($inventario+$costosPorServicios+$compraAccesorios+$compraSoftware);
        if ($utilidadEjercicio > 0 ){
            $utilidadEjercicio = $utilidadEjercicio * (-1);
        }
        $id = self::obtenerID();

        self::ejecutarQuery("INSERT INTO public.ajustespartidas(id, fecha, concepto) VALUES ($id+1,'09-01-2020', 'Por determinacion de Utilidad del Ejercicio');");
        self::ejecutarQuery("INSERT INTO public.ajustes(
	partidas_id, numero, nombre, debe, haber)
	VALUES ($id+1, '1A6', 'INVENTARIOS', 0, $inventario);");
        self::ejecutarQuery("INSERT INTO public.ajustes(
        partidas_id, numero, nombre, debe, haber)
	VALUES ($id+1, '5A1', 'INGRESOS POR SERVICIOS', $ingresoPorServicio,0);");
        self::ejecutarQuery("INSERT INTO public.ajustes(
        partidas_id, numero, nombre, debe, haber)
	VALUES ($id+1, '5A3', 'VENTA DE SOFTWARE', $ventaDeSoftware,0);");
        self::ejecutarQuery("INSERT INTO public.ajustes(
        partidas_id, numero, nombre, debe, haber)
	VALUES ($id+1, '5A2', 'VENTA DE ACCESORIOS CONSUMIBLES', $ventaDeAccesorios,0);");
        self::ejecutarQuery("INSERT INTO public.ajustes(
        partidas_id, numero, nombre, debe, haber)
	VALUES ($id+1, '4A1', 'COSTOS POR SERVICIOS', 0,$costosPorServicios);");
        self::ejecutarQuery("INSERT INTO public.ajustes(
        partidas_id, numero, nombre, debe, haber)
	VALUES ($id+1, '4A2', 'COMPRAS DE ACCESORIOS Y CONSUMIBLES', 0, $compraAccesorios);");
        self::ejecutarQuery("INSERT INTO public.ajustes(
        partidas_id, numero, nombre, debe, haber)
	VALUES ($id+1, '4A3', 'COMPRAS DE SOFTWARE', 0, $compraSoftware);");
        self::ejecutarQuery("INSERT INTO public.ajustes(
        partidas_id, numero, nombre, debe, haber)
	VALUES ($id+1, '3A1', 'CAPITAL', 0, $utilidadEjercicio);");

        $query = "SELECT DISTINCT nombre from ajustes";
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
                    $query3 = "SELECT SUM(debe - haber) as Resta FROM ajustes WHERE ajustes.nombre='$numString';
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

        return $this->render('balance_general/index.html.twig', [
            'variable' => ($ventaDeSoftware)-($costosPorServicios),
            'nombres' => $nombresDeCuenta,
            'saldos' => $saldos,
            'ing' => $ingresoPorServicio
        ]);
    }

    public function obtenerID(){
        $query = "SELECT MAX(ID) FROM ajustespartidas";
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
