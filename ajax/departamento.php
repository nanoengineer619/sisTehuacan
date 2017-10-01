<?php
require_once "../modelos/Departamento.php";

$departamento=new Departamento();

$iddepartamento=isset($_POST["iddepartamento"])? limpiarCadena($_POST["iddepartamento"]):"";
$idedificio=isset($_POST["idedificio"])? limpiarCadena($_POST["idedificio"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$total_consumo=isset($_POST["total_consumo"])? limpiarCadena($_POST["total_consumo"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($iddepartamento)){
			$rspta=$departamento->insertar($idedificio,$nombre,$total_consumo,$fecha,$_POST["idelemento"],$_POST["cantidad"],$_POST["funcionando"],$_POST["fundidas"],$_POST["potencia_unidad"],$_POST["potencia_total"],$_POST["capacidad"],$_POST["tiempo_operacion"],$_POST["consumo"]);
			echo $rspta ? "Departamento registrado" : "Departamento no se pudo registrar";
		}
		else {
			$rspta=$departamento->editar($iddepartamento,$idedificio,$nombre,$total_consumo,$fecha,$_POST["idelemento"],$_POST["cantidad"],$_POST["funcionando"],$_POST["fundidas"],$_POST["potencia_unidad"],$_POST["potencia_total"],$_POST["capacidad"],$_POST["tiempo_operacion"],$_POST["consumo"]);
			echo $rspta ? "Departamento registrado" : "Departamento no se pudo registrar";
		}
	break;
	case 'mostrar':
		$rspta=$departamento->mostrar($iddepartamento);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
    
    case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $departamento->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Elemento</th>
                                    <th>Cantidad</th>
                                    <th>Funcionando</th>
                                    <th>Fallando</th>
                                    <th>Potencia Watts</th>
                                    <th>P. Total</th>
                                    <th>KW</th>
                                    <th>T. Operacion Semanal</th>
                                    <th>Consumo Semanal KW</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->funcionando.'</td><td>'.$reg->fundidas.'</td><td>'.$reg->potencia_unidad.'</td><td>'.$reg->potencia_total.'</td><td>'.$reg->capacidad.'</td><td>'.$reg->tiempo_operacion.'</td><td style="background:#3B8F7B; color:#fff;">KW '.$reg->consumo.'</td></tr>';
					$total=$total+ ($reg->consumo);
				}
		echo '<tfoot>
                                    <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="totalc" name="totalc">kw '.$total.'</h4><input type="hidden" name="total_cons" id="total_cons" value="'.$total.'"></th> 
                                </tfoot> 
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$departamento->listar();
 		//Vamos a declarar un array
 		$data=Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->iddepartamento.')"><i class="fa fa-pencil"></i></button>',
 				"1"=>$reg->edificio,
 				"2"=>$reg->nombre,
 				"3"=>$reg->fecha,
 				"4"=>$reg->total_consumo,
 				"5"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
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
	case 'listarElementos':
		require_once "../modelos/Elemento.php";
		$elemento=new Elemento();

		$rspta=$elemento->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idelemento.',\''.$reg->nombre.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->nombre
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
