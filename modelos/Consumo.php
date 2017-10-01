<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consumo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql="INSERT INTO edificio (nombre,condicion)
		VALUES ('$nombre','1')";

		$idedificio=ejecutarConsulta_retornarID($sql);

		$sql="INSERT INTO interior (idedificio,fecha_hora,consumo_total,estado)
		VALUES ('$idedificio','0000-00-00','0','0')";

		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idedificio,$nombre)
	{
		$sql="UPDATE edificio SET nombre='$nombre' WHERE idedificio='$idedificio'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idedificio)
	{
		$sql="UPDATE edificio SET condicion='0' WHERE idedificio='$idedificio'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idedificio)
	{
		$sql="UPDATE edificio SET condicion='1' WHERE idedificio='$idedificio'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idedificio)
	{
		$sql="SELECT * FROM edificio WHERE idedificio='$idedificio'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT SUM(cons_semana) as semana, SUM((cons_semana) *4) as mes, SUM((cons_semana) * 24) as semestre FROM exterior;";
        return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT SUM(consumo_total) as ssemana, SUM((consumo_total) *4) as mess, SUM((consumo_total) * 24) as ssemestre FROM interior";
		return ejecutarConsulta($sql);		
	}
}

?>