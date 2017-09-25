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
	public function insertar($idedificio,$nombre,$elemento,$cantidad,$potencia,$potencia_total,$capacidad,$funcionando,$fundidas,$descripcion,$fecha_hora)
	{
		$sql="INSERT INTO departamento (idedificio,nombre,elemento,cantidad,potencia,potencia_total,capacidad,funcionando,fundidas,descripcion,fecha_hora)
		VALUES ('$idedificio','$nombre','$elemento','$cantidad','$potencia','$potencia_total','$capacidad','$funcionando','$fundidas','$descripcion','$fecha_hora')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($iddepartamento,$idedificio,$nombre,$elemento,$cantidad,$potencia,$potencia_total,$capacidad,$funcionando,$fundidas,$descripcion,$fecha_hora)
	{
		$sql="UPDATE departamento SET idedificio='$idedificio',nombre='$nombre',elemento='$elemento',cantidad='$cantidad',potencia='$potencia',potencia_total='$potencia_total',capacidad='$capacidad',funcionando='$funcionando',fundidas='$fundidas',descripcion='$descripcion',fecha_hora='$fecha_hora' WHERE iddepartamento='$iddepartamento'";
		return ejecutarConsulta($sql);
	}
	public function desactivar($iddepartamento)
	{
		$sql="DELETE FROM departamento  WHERE iddepartamento='$iddepartamento'";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($iddepartamento)
	{
		$sql="SELECT * FROM departamento WHERE iddepartamento='$iddepartamento'";
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
		$sql="SELECT d.iddepartamento,d.idedificio,e.nombre as edificio,d.nombre,d.elemento,d.cantidad,d.potencia,d.potencia_total,d.capacidad,d.funcionando,d.fundidas,d.descripcion,d.fecha_hora FROM departamento d INNER JOIN edificio e ON d.idedificio=e.idedificio";
		return ejecutarConsulta($sql);		
	}
}

?>