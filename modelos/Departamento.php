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
	public function editar($iddepertamento,$idedificio,$nombre,$elemento,$cantidad,$potencia,$potencia_total,$capacidad,$funcionando,$fundidas,$descripcion,$fecha_hora)
	{
		$sql="UPDATE departamento SET idedificio='$idedificio',nombre='$nombre',elemento='$elemento',cantidad='$cantidad',potencia='$potencia',potencia_total='$potencia_total',capacidad='$capacidad',funcionando='$funcionando',fundidas='$fundidas',descripcion='$descripcion',fecha_hora='$fecha_hora' WHERE iddepertamento='$iddepertamento'";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($iddepertamento)
	{
		$sql="SELECT * FROM departamento WHERE iddepertamento='$iddepertamento'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT d.iddepertamento,d.idedificio,e.nombre as edificio,d.codigo,d.nombre,d.stock,d.descripcion,d.imagen,d.condicion FROM departamento p INNER JOIN edificio e ON d.idedificio=e.idedificio";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT d.iddepertamento,d.idedificio,e.nombre as edificio_nom,d.nombre,d.elemento,d.cantidad,d.potencia,d.potencia_total,d.capacidad,d.funcionando,d.fundidas,d.descripcion,d.fecha_hora FROM departamento a INNER JOIN edificio e ON d.idedificio=e.idedificio";
		return ejecutarConsulta($sql);		
	}
}

?>