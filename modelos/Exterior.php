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
	public function insertar($nombre,$cantidad,$funcionando,$potencia_unidad,$instalada_watts,$instalada_kw,$t_operacion_sem,$cons_semana,$t_op_mensual,$cons_mes,$cons_semestre,$fundidas,$fecha)
	{
		$sql="INSERT INTO exterior (nombre,cantidad,funcionando,potencia_unidad,instalada_watts,instalada_kw, t_operacion_sem,cons_semana,t_op_mensual,cons_mes,cons_semestre,fundidas,fecha)
		VALUES ('$nombre','$cantidad','$funcionando','$potencia_unidad','$instalada_watts','$instalada_kw','$t_operacion_sem','$cons_semana','$t_op_mensual','$cons_mes','$cons_semestre','$fundidas','$fecha')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idexterior,$nombre,$cantidad,$funcionando,$potencia_unidad,$instalada_watts,$instalada_kw,$t_operacion_sem,$cons_semana,$t_op_mensual,$cons_mes,$cons_semestre,$fundidas,$fecha)
	{
		$sql="UPDATE exterior SET nombre='$nombre',cantidad='$cantidad',funcionando='$funcionando',potencia_unidad='$potencia_unidad',instalada_watts='$instalada_watts',instalada_kw='$instalada_kw',t_operacion_sem='$t_operacion_sem',cons_semana='$cons_semana',t_op_mensual='$t_op_mensual',cons_mes='$cons_mes',cons_semestre='$cons_semestre',fundidas='$fundidas',fecha='$fecha' WHERE idexterior='$idexterior'";
		return ejecutarConsulta($sql);
	}
	//Implementamos un método para eliminar un registro
	public function eliminar($idexterior)
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
