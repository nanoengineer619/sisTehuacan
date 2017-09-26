<?php
require_once "../modelos/Elemento.php";

$elemento=new Elemento();

$idelemento=isset($_POST["idelemento"])? limpiarCadena($_POST["idelemento"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idelemento)){
			$rspta=$elemento->insertar($nombre);
			echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
		}
		else {
			$rspta=$elemento->editar($idelemento,$nombre);
			echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$elemento->desactivar($idelemento);
 		echo $rspta ? "Elemento Eliminado" : "Eliminado no se puede Eliminar";
	break;

	case 'mostrar':
		$rspta=$elemento->mostrar($idelemento);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$elemento->listar();
 		//Vamos a declarar un array
 		$data=Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idelemento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idelemento.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idelemento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idelemento.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>($reg->condicion)?'<span class="label bg-green">Activo</span>':
 				'<span class="label bg-red">Inactivo</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectEdificio":
		require_once "../modelos/Edificio.php";
		$edificio = new Edificio();

		$rspta = $edificio->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idedificio . '>' . $reg->nombre . '</option>';
				}
	break;
	case "selectDepartamento":
		require_once "../modelos/modulo.php";
		$modulo = new Modulo();

		$rspta = $modulo->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->nombre . '>' . $reg->nombre . '</option>';
				}
	break;
}
?>
