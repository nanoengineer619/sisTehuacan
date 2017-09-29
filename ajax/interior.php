<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Interior.php";

$interior=new Interior();

$idinterior=isset($_POST["idinterior"])? limpiarCadena($_POST["idinterior"]):"";
$idedificio=isset($_POST["idedificio"])? limpiarCadena($_POST["idedificio"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$consumo_total=isset($_POST["total_consumo"])? limpiarCadena($_POST["total_consumo"]):"";

$iddepartamento=isset($_POST["iddepartamento"])? limpiarCadena($_POST["iddepartamento"]):"";
$total_consumo=isset($_POST["total_c_elem"])? limpiarCadena($_POST["total_c_elem"]):"";
$consumo_mensual=isset($_POST["total_c_mes"])? limpiarCadena($_POST["total_c_mes"]):"";
$consumo_semestral=isset($_POST["total_c_sems"])? limpiarCadena($_POST["total_c_sems"]):"";
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (!empty($idinterior)){
			$rspta=$interior->insertar($idinterior,$idedificio,$fecha_hora,$consumo_total,$_POST["iddepartamento"],$_POST["consumo_semanal"],$_POST["consumo_mensual"],$_POST["consumo_semestral"]);
			echo $rspta ? "Departamentos registrados" : "No se pudieron registrar todos los datos de los Departamentos";
		}
		else {
                echo "Faltan Datos verifique el departamento";
		}
	break;
	case 'guardarelementos':
		if (!empty($iddepartamento)){
			$rspta=$interior->actualizar($iddepartamento,$total_consumo,$consumo_mensual,$consumo_semestral,$_POST["idelemento"],$_POST["funcionando"],$_POST["fundidas"],$_POST["tiempo_operacion"],$_POST["consumo"]);
			echo $rspta ? "Datos Actualizados" : "No se pudieron actualizar los Datos";
		}
		else {
                echo "Faltan Datos verifique el Elemento";
		}
	break;
    case 'upDep':
         $idinterior=$_GET["idi"];
         $total_dep=$_GET["idt"];
		$rspta=$interior->actinter($idinterior,$total_dep);
 		echo $rspta ? "Ingreso anulado" : "Ingreso no se puede anular";
	break;
	case 'anular':
		$rspta=$interior->anular($idinterior);
 		echo $rspta ? "Ingreso anulado" : "Ingreso no se puede anular";
	break;

	case 'mostrar':
		$rspta=$interior->mostrar($idinterior);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idinterior
		$id=$_GET['id'];
		$ts=0;
		$tm=0;
		$tsm=0;
		$rspta = $interior->listarDetalle($id);
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Departamento</th>
                                    <th>Consumo Semanal</th>
                                    <th>Consumo Mensual</th>
                                    <th>Consumo Semestral</th>
                                    <th style="display:none;"></th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td><a data-toggle="modal" href="#myDep"><button id="btnAgregarElm" type="button" class="btn btn-info" title="Detalle" onclick="listarElementos('.$reg->iddepartamento.')"><i class="fa fa-eye"></i></button></a></td><td>'.$reg->nombre.'</td><td><span>'.$reg->consumo_semanal.'</span></td><td>'.$reg->consumo_semestral.'</td><td><span>'.$reg->consumo_semestral.'</span></td><td style="display:none;"><input type="number" name="iddepart[]" value="'.$reg->iddepartamento.'"></td></tr>';
                       $ts=$ts+($reg->consumo_semanal);
                       $tm=$tm+($reg->consumo_mensual);
                       $tsm=$tsm+($reg->consumo_semestral);
				}
		echo '<tfoot style="background-color:#77BAAD; color:#fff;">
                                    <th><h4>Totales</h4></th>
                                    <th><input type="number" name="total_dep" id="total_dep" value="'.$ts.'"></th>
                                    <th><h4 id="totalss">'.$ts.' kW</h4></th>
                                    <th><h4 id="totalmess">'.$tm.' kW</h4></th>
                                    <th><h4 id="totalsemm">'.$tsm.' kW</h4></th>
                                    <th style="display:none;"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$interior->listarEdificio();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){

 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-info" title="Detalle" onclick="mostrar('.$reg->idedificio.','.$reg->idinterior.'); btnActhide(false);"><i class="fa fa-eye"></i></button>':'<button class="btn btn-info" title="Agregar" onclick="mostrar('.$reg->idedificio.','.$reg->idinterior.')">Activar</button>',
 				"1"=>$reg->nombre,
 				"2"=>($reg->consumo_total==0.000)?'<span><i>Sin Datos</i></span>':$reg->consumo_total,
 				"3"=>($reg->mes==0.000)?'<span><i>Sin Datos</i></span>':$reg->mes,
 				"4"=>($reg->sem==0.000)?'<span><i>Sin Datos</i></span>':$reg->sem,
 				"5"=>($reg->fecha_hora==0000-00-00)?'<span><i>Sin Datos</i></span>':$reg->fecha_hora,
 				"6"=>($reg->estado)?'<span class="label bg-green">Activo</span>':
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

	case 'listarDepartamento':
		require_once "../modelos/Departamento.php";
		$departamento=new Departamento();

		$rspta=$departamento->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->iddepartamento.',\''.$reg->nombre.'\','.$reg->total_consumo.')"><i class="fa fa-pencil"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->fecha,
 				"3"=>$reg->total_consumo,
 				"4"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
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

	case 'listarElementos':
		require_once "../modelos/Departamento.php";
		$departamento=new Departamento();
        
        $id=$_GET['id'];
		$total=0;
		$rspta = $departamento->listarDetalle($id);
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Elemento</th>
					                <th>Cantidad</th>
					                <th>Funcionando</th>
					                <th>Fundidos</th>
					                <th>Potencia/U</th>
					                <th>P. Total</th>
					                <th>Capacida KW</th>
					                <th>T. Operacion</th>
					                <th>Consumo Semanal</th>
					                <th>Total</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					$subt=$capacidad * $tiempo_operacion;
					echo '<tr class="filas"><td><input type="hidden" class="form-control" name="idelemento[]" id="idelemento[]" value="'.$reg->idelemento.'">'.$reg->nombre.'</td><td><input type="number" readonly class="form-control" readonly name="" id="" value="'.$reg->cantidad.'"></td><td><input type="number" class="form-control" name="funcionando[]" onkeyup="calculartelem();" id="funcionando[]" value="'.$reg->funcionando.'"></td><td><input type="number" onkeyup="calculartelem();" class="form-control" name="fundidas[]" id="fundidas[]" value="'.$reg->fundidas.'"></td><td><input type="number" class="form-control" readonly name="" id="" value="'.$reg->potencia_unidad.'"></td><td><input type="number" class="form-control" readonly name="" id="" value="'.$reg->potencia_total.'"></td><td><input type="number" class="form-control" readonly name="capacidad[]" id="capacidad[]" value="'.$reg->capacidad.'"></td><td><input type="number" class="form-control" onkeyup="calculartelem();" name="tiempo_operacion[]" id="tiempo_operacion[]" value="'.$reg->tiempo_operacion.'"></td><td><input type="number" class="form-control" readonly name="consumo[]" id="consumo[]" value="'.$reg->consumo.'"><span style="display:none;" name="subt" id="subt">'.$subt.'</span></td><td></td></tr>';
					$total=$total+($reg->consumo);

				}
		echo '<tfoot style="background-color:#77BAAD; color:#fff;">
                                    <th><h4>Totales</h4></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><input type="hidden" name="total_c_elem" id="total_c_elem"></th> 
                                    <th><input type="hidden" name="total_c_mes" id="total_c_mes"></th>
                                    <th><input type="hidden" name="total_c_sems" id="total_c_sems"></th>
                                    <th><input type="hidden" name="iddepartamento" id="iddepartamento" value="'.$id.'"></th>
                                    <th><h4 id="total_c_e">KW '.$total.'</h4></th> 
                                </tfoot>';
	break;
}
?>