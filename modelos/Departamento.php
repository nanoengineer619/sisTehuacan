<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Departamento
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idedificio,$nombre,$total_consumo,$fecha,$idelemento,$cantidad,$funcionando,$fundidas,$potencia_unidad,$potencia_total,$capacidad,$tiempo_operacion,$consumo)
	{
		$sql="INSERT INTO departamento (idedificio,nombre,total_consumo,fecha,estado)
		VALUES ('$idedificio','$nombre','$total_consumo','$fecha','1')";
		//return ejecutarConsulta($sql);
		$iddepartamentonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;	
		$sw=true;

		while ($num_elementos < count($idelemento))
		{
			$sql_detalle = "INSERT INTO detalle_departamento (iddepartamento,idelemento,cantidad,funcionando,fundidas,potencia_unidad,potencia_total,capacidad,tiempo_operacion,consumo) VALUES ('$iddepartamentonew','$idelemento[$num_elementos]','$cantidad[$num_elementos]','$funcionando[$num_elementos]','$fundidas[$num_elementos]','$potencia_unidad[$num_elementos]','$potencia_total[$num_elementos]','$capacidad[$num_elementos]','$tiempo_operacion[$num_elementos]','$consumo[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	//Implementamos un método para editar registros
	public function editar($iddepartamento,$idedificio,$nombre,$total_consumo,$fecha,$idelemento,$cantidad,$funcionando,$fundidas,$potencia_unidad,$potencia_total,$capacidad,$tiempo_operacion,$consumo)
	{
		$sql="UPDATE departamento SET  idedificio='$idedificio',nombre='$nombre',total_consumo='$total_consumo',fecha='$fecha' WHERE iddepartamento = '$iddepartamento'";
		   ejecutarConsulta($sql);

		$num_elementos=0;	
		$sw=true;

		while ($num_elementos < count($idelemento))
		{
			$sql_detalle = "INSERT INTO detalle_departamento (iddepartamento,idelemento,cantidad,funcionando,fundidas,potencia_unidad,potencia_total,capacidad,tiempo_operacion,consumo) VALUES ('$iddepartamento','$idelemento[$num_elementos]','$cantidad[$num_elementos]','$funcionando[$num_elementos]','$fundidas[$num_elementos]','$potencia_unidad[$num_elementos]','$potencia_total[$num_elementos]','$capacidad[$num_elementos]','$tiempo_operacion[$num_elementos]','$consumo[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}
	public function desactivar($iddepartamento)
	{
		$sql="DELETE FROM departamento  WHERE iddepartamento='$iddepartamento'";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($iddepartamento)
	{
		$sql="SELECT d.iddepartamento,e.nombre as edificio,d.nombre,DATE(d.fecha) as fecha,d.total_consumo,d.fecha,d.estado FROM departamento d INNER JOIN edificio e ON d.idedificio=e.idedificio WHERE iddepartamento='$iddepartamento'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT d.iddepartamento,e.nombre as edificio,d.nombre,DATE(d.fecha) as fecha,d.total_consumo,d.fecha,d.estado FROM departamento d INNER JOIN edificio e ON d.idedificio=e.idedificio";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros activos
	public function listarDetalle($iddepartamento)
	{
		$sql="SELECT dd.iddepartamento,dd.idelemento,e.nombre,dd.cantidad,dd.funcionando,dd.fundidas,dd.potencia_unidad,dd.potencia_total,dd.capacidad,dd.tiempo_operacion,dd.consumo FROM detalle_departamento dd INNER JOIN elemento e ON dd.idelemento=e.idelemento WHERE dd.iddepartamento ='$iddepartamento'";
		return ejecutarConsulta($sql);		
	}
}

?>