<?php
require_once "../modelos/Exterior.php";

$exterior=new Exterior();

$idexterior=isset($_POST["idexterior"])? limpiarCadena($_POST["idexterior"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";
$potencia=isset($_POST["potencia"])? limpiarCadena($_POST["potencia"]):"";
$potencia_total=isset($_POST["potencia_total"])? limpiarCadena($_POST["potencia_total"]):"";
$capacidad=isset($_POST["capacidad"])? limpiarCadena($_POST["capacidad"]):"";
$tiempo_operacion=isset($_POST["tiempo_operacion"])? limpiarCadena($_POST["tiempo_operacion"]):"";
$consumo=isset($_POST["consumo"])? limpiarCadena($_POST["consumo"]):"";
$funcionando=isset($_POST["funcionando"])? limpiarCadena($_POST["funcionando"]):"";
$fundidas=isset($_POST["fundidas"])? limpiarCadena($_POST["fundidas"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idexterior)){
			$rspta=$exterior->insertar($nombre,$cantidad,$potencia,$potencia_total,$capacidad,$tiempo_operacion,$consumo,$funcionando,$fundidas,$fecha,$descripcion);
			echo $rspta ? "Exterior registrado" : "Exterior no se pudo registrar";
		}
		else {
			$rspta=$exterior->editar($nombre,$cantidad,$potencia,$potencia_total,$capacidad,$tiempo_operacion,$consumo,$funcionando,$fundidas,$fecha,$descripcion);
			echo $rspta ? "Exterior actualizado" : "Exterior no se pudo actualizar";
		}
	break;
	case 'mostrar':
		$rspta=$exterior->mostrar($idexterior);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$exterior->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
			$data[]=array(
 			"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idexterior.')"><i class="fa fa-eye"></i></button>',
			"1"=>$reg->nombre,
			"2"=>$reg->cantidad,
			"3"=>$reg->potencia,
			"4"=>$reg->potencia_total,
			"5"=>$reg->capacidad,
			"6"=>$reg->tiempo_operacion,
			"7"=>$reg->consumo,
			"8"=>$reg->funcionando,
			"9"=>$reg->fundidas,
			"10"=>$reg->fecha,
			"11"=>$reg->descripcion
			);
	}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;
/*
	case "selectEdificio":
		require_once "../modelos/Edificio.php";
		$edificio = new Edificio();

		$rspta = $edificio->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idedificio . '>' . $reg->nombre . '</option>';
				}
	break;
  */
}
?>
