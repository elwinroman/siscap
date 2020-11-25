<?php 

class AjaxModel {
	private $database, $db;

	public function __construct() {
		require '../config/bd.php';
		$this->database = new Database();
		$this->db = $this->database->conectar();	
	}
	private function consulta($sql) {
		$query = $this->db->query($sql);
		$this->db->close();
		return $query;
	}
	/** 
	 * Obtiene lista de oficinas-jefe ordenado por nombre
	 * return{Object mysqli_result} $result
	 */
	public function getOficinasJefe() {
		$sql = "SELECT id, nombre FROM oficinas WHERE oficina_id IS NULL ORDER BY nombre";
		$result = $this->consulta($sql);
		return $result;
	}
}

 ?>