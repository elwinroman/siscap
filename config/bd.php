<?php 
// error_reporting(1);		// Desactiva toda notificación de error
class Database {
	private $host, $user, $pass, $database, $charset;

	public function __construct() {
		$this->host = 'localhost';
		$this->user = 'root';
		$this->pass = '';
		$this->database = 'worker_master1';
		$this->charset = 'utf8';
	}
	public function connect() {
		$conn = new mysqli($this->host, $this->user, $this->pass, $this->database);
		$conn->query("SET NAMES '" . $this->charset . "'");
		
		if($conn)
			return $conn;
		else
			//mysqli_close($db);
			die('Error de Conexión (' . mysqli_connect_errno() . ') '.mysqli_connect_error());
	}
}
 ?>