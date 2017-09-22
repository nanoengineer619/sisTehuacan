<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Exterior
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$cantidad,$potencia,$potencia_total,$capacidad,$tiempo_operacion,$consumo,$funcionando,$fundidas,$fecha,$descripcion)
	{
		$sql="INSERT INTO exterior (nombre,cantidad,potencia,potencia_total,capacidad,tiempo_operacion, consumo,funcionando,fundidas,fecha,descripcion)
		VALUES ('$nombre','$cantidad','$potencia','$potencia_total','$capacidad','$tiempo_operacion','$consumo','$funcionando','$fundidas','$fecha','$descripcion')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idexterior,$nombre,$cantidad,$potencia,$potencia_total,$capacidad,$tiempo_operacion,$consumo,$funcionando,$fundidas,$fecha,$descripcion)
	{
		$sql="UPDATE exterior SET idexterior='$idexterior',nombre='$nombre',cantidad='$cantidad',potencia='$potencia',potencia_total='$potencia_total,capacidad='$capacidad',tiempo_operacion='$tiempo_operacion',consumo='$consumo'funcionando='$funcionando',fundidas='$fundidas',fecha='$fecha',descripcion='$descripcion' WHERE idexterior='$idexterior'";
		return ejecutarConsulta($sql);
	}
	public function desactivar($idexterior)
	{
		$sql="DELETE FROM exterior WHERE idexterior='$idexterior'";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idexterior)
	{
		$sql="SELECT * FROM exterior WHERE idexterior='$idexterior'";
		return ejecutarConsultaSimpleFila($sql);
	}

  //Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM exterior";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los registros y mostrar en el select
  /*
	public function select()
	{
		$sql="SELECT * FROM exterior where condicion=1";
		return ejecutarConsulta($sql);
	}*/
}
?>
