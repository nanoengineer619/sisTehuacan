<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Proveedor
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$direccion,$telefono,$email)
	{
		$sql="INSERT INTO proveedor (nombre,direccion,telefono,email)
		VALUES ('$nombre','$direccion','$telefono','$email')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idproveedor,$nombre,$direccion,$telefono,$email)
	{
		$sql="UPDATE proveedor SET nombre='$nombre',direccion='$direccion',telefono='$telefono',email='$email' WHERE idproveedor='$idproveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function eliminar($idproveedor)
	{
		$sql="DELETE FROM proveedor WHERE idproveedor='$idproveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idproveedor)
	{
		$sql="SELECT * FROM proveedor WHERE idproveedor='$idproveedor'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listarp()
	{
		$sql="SELECT * FROM proveedor";
		return ejecutarConsulta($sql);		
	}
}

?>