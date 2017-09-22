<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Interior.php";

$interior=new Interior();

$idedificio=isset($_POST["idedificio"])? limpiarCadena($_POST["idedificio"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idingreso)){
			$rspta=$interior->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"]);
			echo $rspta ? "Ingreso registrado" : "No se pudieron registrar todos los datos del ingreso";
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$interior->anular($idingreso);
 		echo $rspta ? "Ingreso anulado" : "Ingreso no se puede anular";
	break;

	case 'mostrar':
		$rspta=$interior->mostrar($idedificio);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];
		$rspta = $interior->listarDetalle($id);
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Departamento</th>
                                    <th>Tiempo de Operacion Total</th>
                                    <th>Consumo Por Departamento</th>
                                    <th>Total de Consumo</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td><a data-toggle="modal" href="#myModal"><button id="btnAgregarDep" type="button" class="btn btn-warning"><span class="fa fa-eye"></span></button></a></td><td><b>'.$reg->nombre.'</b></td><td><span>0.00 Kw</span></td><td><span>0.00 Kw</span></td><td><span>0.00 Kw</span></td></tr>';
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total"></h4><input type="hidden" name="total_compra" id="total_compra"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$interior->listarEdificio();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion==1)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idedificio.')"><i class="fa fa-eye"></i></button>':'<span>Edificio No Disponible</span>',
 				"1"=>$reg->nombre,
 				"2"=>'<span>KW</span>',
 				"3"=>'<span>KW</span>',
 				"4"=>'<span>KW</span>'
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
 				"0"=>$reg->elemento,
 				"1"=>$reg->cantidad,
 				"2"=>$reg->potencia,
 				"3"=>$reg->potencia_total,
 				"4"=>$reg->capacidad,
 				"5"=>'<input type="number" class="form-control" step="any" name="consumo" id="consumo">',
 				"6"=>'<span>kW</span>',
                "7"=>$reg->capacidad,
                "8"=>$reg->funcionando,
                "9"=>$reg->fundidas,
                "10"=>'<button class="btn btn-info" onclick="agregarDetalle('.$reg->iddepartamento.',\''.$reg->nombre.'\','.$reg->capacidad.')"><i class="fa fa-refresh"></i></span></button>'
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