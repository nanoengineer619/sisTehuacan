<?php 
require_once "../modelos/Edificio.php";

$edificio=new Edificio();

$idedificio=isset($_POST["idedificio"])? limpiarCadena($_POST["idedificio"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idedificio)){
			$rspta=$edificio->insertar($nombre);
			echo $rspta ? "Edificio registrada" : "Edificio no se pudo registrar";
		}
		else {
			$rspta=$edificio->editar($idedificio,$nombre);
			echo $rspta ? "Edificio actualizada" : "Edificio no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$edificio->desactivar($idedificio);
 		echo $rspta ? "Edificio Desactivada" : "Edificio no se puede desactivar";
	break;

	case 'activar':
		$rspta=$edificio->activar($idedificio);
 		echo $rspta ? "Edificio activada" : "Edificio no se puede activar";
	break;

	case 'mostrar':
		$rspta=$edificio->mostrar($idedificio);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$edificio->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idedificio.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idedificio.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idedificio.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idedificio.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>