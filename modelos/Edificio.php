<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Edificio
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
		$sql="SELECT * FROM edificio";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM edificio where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>