<?php 
class Database {
	public static function conectar() {
		$db = new mysqli("localhost","root","","worker_master1");
		$db->query("SET NAMES 'utf8'");

		if($db) {
			return $db;
		} else {
			die('Error de Conexión (' . mysqli_connect_errno() . ') '.mysqli_connect_error());
			//mysqli_close($db); //cierra la conexion a nuestra base de datos, un punto de seguridad importante.
		}
	}
}
