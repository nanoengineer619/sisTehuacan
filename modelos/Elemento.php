<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Elemento
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql="INSERT INTO elemento (nombre,condicion)
		VALUES ('$nombre','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idelemento,$nombre)
	{
		$sql="UPDATE elemento SET nombre='$nombre',condicion='1' WHERE idelemento='$idelemento'";
		return ejecutarConsulta($sql);
	}
	public function desactivar($idelemento)
	{
		$sql="DELETE FROM elemento  WHERE idelemento='$idelemento'";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idelemento)
	{
		$sql="SELECT * FROM elemento WHERE idelemento='$idelemento'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM elemento";
		return ejecutarConsulta($sql);	
	}

	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT * FROM elemento WHERE condicion='1'";
		return ejecutarConsulta($sql);			
	}
}

?>