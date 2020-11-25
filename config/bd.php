<?php 
class Database {
	private $host, $user, $pass, $database, $charset;

	public function __construct() {
		$this->host = 'localhost';
		$this->user = 'root';
		$this->pass = '';
		$this->database = 'worker_master1';
		$this->charset = 'utf8';
	}
	public function conectar() {
		$con = new mysqli($this->host, $this->user, $this->pass, $this->database);
		$con->query("SET NAMES '" . $this->charset . "'");
	
		if($con)
			return $con;
		else {
			die('Error de Conexión (' . mysqli_connect_errno() . ') '.mysqli_connect_error());
		}
	}
}
/*class Database {
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
}*/
 ?>