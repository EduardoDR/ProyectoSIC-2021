<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AjustesController extends AbstractController
{
    /**
     * @Route("/ajustes", name="ajustes")
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

        return $this->render('ajustes/index.html.twig', [
            'nombres' => $nombresDeCuenta,
            'saldos' => $saldos,
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
