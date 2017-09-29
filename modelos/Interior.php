<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Interior
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idinterior,$idedificio,$fecha_hora,$consumo_total,$iddepartamento,$consumo_semanal,$consumo_mensual,$consumo_semestral)
	{
		$sql="UPDATE interior SET  idedificio='$idedificio',fecha_hora='$fecha_hora',consumo_total='$consumo_total',estado='1' WHERE idinterior = '$idinterior'";
		   ejecutarConsulta($sql);

		$num_elementos=0;	
		$sw=true;

		while ($num_elementos < count($iddepartamento))
		{
			$sql_detalle = "INSERT INTO detalle_interiores (idinterior,iddepartamento,consumo_semanal,consumo_mensual,consumo_semestral) VALUES ('$idinterior','$iddepartamento[$num_elementos]','$consumo_semanal[$num_elementos]','$consumo_mensual[$num_elementos]','$consumo_semestral[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

    public function actualizar($iddepartamento,$total_consumo,$consumo_mensual,$consumo_semestral,$idelemento,$funcionando,$fundidas,$tiempo_operacion,$consumo)
	{
		$sql="UPDATE departamento SET  total_consumo='$total_consumo' WHERE iddepartamento = '$iddepartamento'";
		   ejecutarConsulta($sql);

		 $sql="UPDATE detalle_interiores SET  consumo_semanal='$total_consumo',consumo_mensual='$consumo_mensual',consumo_semestral='$consumo_semestral' WHERE iddepartamento = '$iddepartamento'";
		   ejecutarConsulta($sql);

		$num_elementos=0;	
		$sw=true;

		while ($num_elementos < count($idelemento))
		{
			$sql_detalle = "UPDATE detalle_departamento SET funcionando='$funcionando[$num_elementos]',fundidas='$fundidas[$num_elementos]',tiempo_operacion='$tiempo_operacion[$num_elementos]',consumo='$consumo[$num_elementos]' WHERE idelemento='$idelemento[$num_elementos]' AND iddepartamento='$iddepartamento'";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}
    //Implementamos un método para anular categorías
	public function actinter($idinterior,$total_dep)
	{
		$sql="UPDATE interior SET consumo_total='$total_dep' WHERE idinterior='$idinterior'";
		return ejecutarConsulta($sql);
	}
	
	//Implementamos un método para anular categorías
	public function anular($idingreso)
	{
		$sql="UPDATE ingreso SET estado='Anulado' WHERE idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idinterior)
	{
		$sql="SELECT i.idinterior,i.idedificio,e.nombre,i.consumo_total,i.estado FROM interior i inner join edificio e on i.idedificio=e.idedificio WHERE idinterior ='$idinterior'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idinterior)
	{
		$sql="SELECT di.iddetalle_interiores as iddetalle,di.idinterior,di.iddepartamento,d.nombre,di.consumo_semanal,di.consumo_mensual, di.consumo_semestral FROM detalle_interiores di inner join departamento d on di.iddepartamento=d.iddepartamento WHERE di.idinterior='$idinterior'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT di.idingreso,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN proveedor p ON i.idproveedor=p.idproveedor INNER JOIN usuario u ON i.idusuario=u.idusuario ORDER BY i.idingreso desc";
		return ejecutarConsulta($sql);		
	}
	public function listarEdificio(){
		$sql="SELECT i.idinterior,i.idedificio,e.nombre,i.consumo_total,(i.consumo_total * 4) as mes,(i.consumo_total * 24) as sem,i.fecha_hora,i.estado FROM interior i inner join edificio e on i.idedificio=e.idedificio";
		return ejecutarConsulta($sql);
	}
	public function listarOtro(){
		$sql="SELECT i.idinterior,i.idedificio,e.nombre,i.consumo_total,(i.consumo_total * 4) as mes,(i.consumo_total * 24) as sem,i.fecha_hora,i.estado FROM edificio e inner join interior i on e.idedificio=i.idedificio";
		return ejecutarConsulta($sql);
	}
}

?>