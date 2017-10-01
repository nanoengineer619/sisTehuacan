<?php 
require_once "../modelos/Consumo.php";

$consumo=new Consumo();

$idedificio=isset($_POST["idedificio"])? limpiarCadena($_POST["idedificio"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idedificio)){
			$rspta=$consumo->insertar($nombre);
			echo $rspta ? "Edificio registrada" : "Edificio no se pudo registrar";
		}
		else {
			$rspta=$consumo->editar($idedificio,$nombre);
			echo $rspta ? "Edificio actualizada" : "Edificio no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$consumo->desactivar($idedificio);
 		echo $rspta ? "Edificio Desactivada" : "Edificio no se puede desactivar";
	break;

	case 'activar':
		$rspta=$consumo->activar($idedificio);
 		echo $rspta ? "Edificio activada" : "Edificio no se puede activar";
	break;

	case 'mostrar':
		$rspta=$consumo->mostrar($idedificio);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$ts=0;
		$tm=0;
		$tsm=0;
		$tis=0;
		$tim=0;
		$tism=0;

		$tts=0;
		$ttm=0;
		$ttsm=0;
		$rspta = $consumo->listar();
		$result = $consumo->select();
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Departamento</th>
                                    <th>Consumo Semanal</th>
                                    <th>Consumo Mensual</th>
                                    <th>Consumo Semestral</th>
                                </thead>';
        /*   ***************************  CONSULTA EXTERIOR *******************************  */
		while ($reg = $rspta->fetch_object())
		{
			  echo '<tr class="filas"><td><span>Exterior</span></td><td>'.$reg->semana.'</td><td>'.$reg->mes.'</td><td>'.$reg->semestre.'</td></tr>';
			  $ts=$reg->semana;
		      $tm=$reg->mes;
		      $tsm=$reg->semestre;
		}
		/*   ***************************  CONSULTA INTERIOR *******************************  */
		while ($res = $result->fetch_object())
		{
			  echo '<tr class="filas"><td><span>Interior</span></td><td>'.$res->ssemana.'</td><td>'.$res->mess.'</td><td>'.$res->ssemestre.'</td></tr>';
			  $tis=$res->ssemana;
		      $tim=$res->mess;
		      $tism=$res->ssemestre;
		}
		      $tts=($ts + ($tis));
		      $ttm=($tm + ($tim));
		      $ttsm=($tsm + ($tism));
		echo '<tfoot style="background-color:#77BAAD; color:#fff;">
                                    <th><h4>Consumo Total</h4></th>
                                    <th><h4 id="totalss">'.$tts.'kW</h4></th>
                                    <th><h4 id="totalmess">'.$ttm.' kW</h4></th>
                                    <th><h4 id="totalsemm">'.$ttsm.' kW</h4></th>
                                </tfoot>';
	break;

	break;
}
?>