<?php
require_once "../modelos/Exterior.php";

$exterior=new Exterior();

$idexterior=isset($_POST["idexterior"])? limpiarCadena($_POST["idexterior"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";
$funcionando=isset($_POST["funcionando"])? limpiarCadena($_POST["funcionando"]):"";
$potencia_unidad=isset($_POST["potencia_unidad"])? limpiarCadena($_POST["potencia_unidad"]):"";
$instalada_watts=isset($_POST["instalada_watts"])? limpiarCadena($_POST["instalada_watts"]):"";
$instalada_kw=isset($_POST["instalada_kw"])? limpiarCadena($_POST["instalada_kw"]):"";
$t_operacion_sem=isset($_POST["t_operacion_sem"])? limpiarCadena($_POST["t_operacion_sem"]):"";
$cons_semana=isset($_POST["cons_semana"])? limpiarCadena($_POST["cons_semana"]):"";
$t_op_mensual=isset($_POST["t_op_mensual"])? limpiarCadena($_POST["t_op_mensual"]):"";
$cons_mes=isset($_POST["cons_mes"])? limpiarCadena($_POST["cons_mes"]):"";
$cons_semestre=isset($_POST["cons_semestre"])? limpiarCadena($_POST["cons_semestre"]):"";
$fundidas=isset($_POST["fundidas"])? limpiarCadena($_POST["fundidas"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idexterior)){
			$rspta=$exterior->insertar($nombre,$cantidad,$funcionando,$potencia_unidad,$instalada_watts,$instalada_kw,$t_operacion_sem,$cons_semana,$t_op_mensual,$cons_mes,$cons_semestre,$fundidas,$fecha);
			echo $rspta ? "Exterior registrado" : "Exterior no se pudo registrar";
		}
		else {
			$rspta=$exterior->editar($nombre,$cantidad,$funcionando,$potencia_unidad,$instalada_watts,$instalada_kw,$t_operacion_sem,$cons_semana,$t_op_mensual,$cons_mes,$cons_semestre,$fundidas,$fecha);
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
			"3"=>$reg->funcionando,
			"4"=>$reg->potencia_unidad,
			"5"=>$reg->instalada_watts,
			"6"=>$reg->instalada_kw,
			"7"=>$reg->t_operacion_sem,
			"8"=>$reg->cons_semana,
			"9"=>$reg->t_op_mensual,
			"10"=>$reg->cons_mes,
			"11"=>$reg->cons_semestre,
			"12"=>$reg->fundidas,
			"13"=>$reg->fecha
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
