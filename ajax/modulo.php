<?php 
require_once "../modelos/Modulo.php";

$modulo=new Modulo();

$idmodulo=isset($_POST["idmodulo"])? limpiarCadena($_POST["idmodulo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idmodulo)){
			$rspta=$modulo->insertar($nombre);
			echo $rspta ? "Edificio registrada" : "Edificio no se pudo registrar";
		}
		else {
			$rspta=$modulo->editar($idmodulo,$nombre);
			echo $rspta ? "Edificio actualizada" : "Edificio no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$modulo->desactivar($idmodulo);
 		echo $rspta ? "Edificio Desactivada" : "Edificio no se puede desactivar";
	break;

	case 'activar':
		$rspta=$modulo->activar($idmodulo);
 		echo $rspta ? "Edificio activada" : "Edificio no se puede activar";
	break;

	case 'mostrar':
		$rspta=$modulo->mostrar($idmodulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$modulo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idmodulo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idmodulo.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idmodulo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idmodulo.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>($reg->condicion)?'<span class="label bg-green">En Servicio</span>':
 				'<span class="label bg-red">Fuera de Servicio</span>'
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