<?php
session_start();
require_once "global.php";
class Herramientas
{
	public function get_conexion()
	{
		$user=DB_USERNAME;
		$pass=DB_PASSWORD;
		$host=DB_HOST;
		$db=DB_NAME;
		try 
		{
			$conexion = new PDO("mysql:host=$host;dbname=$db;",$user,$pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
		    return $conexion;
	    }
	   catch(PDOException $ex)
	    {
	        $msg = "Failed to connect to the database";
	    }

	}
}

?>