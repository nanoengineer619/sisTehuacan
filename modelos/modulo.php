<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Modulo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql="INSERT INTO modulo (nombre,condicion)
		VALUES ('$nombre','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idmodulo,$nombre)
	{
		$sql="UPDATE modulo SET nombre='$nombre' WHERE idmodulo='$idmodulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idmodulo)
	{
		$sql="UPDATE modulo SET condicion='0' WHERE idmodulo='$idmodulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idmodulo)
	{
		$sql="UPDATE modulo SET condicion='1' WHERE idmodulo='$idmodulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idmodulo)
	{
		$sql="SELECT * FROM modulo WHERE idmodulo='$idmodulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM modulo";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM modulo where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>