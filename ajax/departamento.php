<?php
require_once "../modelos/Departamento.php";

$departamento=new Departamento();

$iddepartamento=isset($_POST["iddepartamento"])? limpiarCadena($_POST["iddepartamento"]):"";
$idedificio=isset($_POST["idedificio"])? limpiarCadena($_POST["idedificio"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$elemento=isset($_POST["elemento"])? limpiarCadena($_POST["elemento"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";
$potencia=isset($_POST["potencia"])? limpiarCadena($_POST["potencia"]):"";
$potencia_total=isset($_POST["potencia_total"])? limpiarCadena($_POST["potencia_total"]):"";
$capacidad=isset($_POST["capacidad"])? limpiarCadena($_POST["capacidad"]):"";
$funcionando=isset($_POST["funcionando"])? limpiarCadena($_POST["funcionando"]):"";
$fundidas=isset($_POST["fundidas"])? limpiarCadena($_POST["fundidas"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($iddepartamento)){
			$rspta=$departamento->insertar($idedificio,$nombre,$elemento,$cantidad,$potencia,$potencia_total,$capacidad,$funcionando,$fundidas,$descripcion,$fecha_hora);
			echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
		}
		else {
			$rspta=$departamento->editar($iddepartamento,$idedificio,$nombre,$elemento,$cantidad,$potencia,$potencia_total,$capacidad,$funcionando,$fundidas,$descripcion,$fecha_hora);
			echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
		}
	break;
	case 'mostrar':
		$rspta=$departamento->mostrar($iddepartamento);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$departamento->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->iddepartamento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->iddepartamento.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->iddepartamento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->iddepartamento.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->edificio_nom,
 				"2"=>$reg->nombre,
 				"3"=>$reg->elemento,
 				"4"=>$reg->cantidad,
 				"5"=>$reg->potencia,
 				"6"=>$reg->potencia_total,
                "7"=>$reg->capacidad,
                "8"=>$reg->funcionando,
                "9"=>$reg->fundidas,
                "10"=>$reg->descripcion,
                "11"=>$reg->fecha,
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
}
?>
