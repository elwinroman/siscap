<?php 

class AjaxModel {
	private $database, $db;

	public function __construct() {
		require '../config/bd.php';
		$this->database = new Database();
		$this->db = $this->database->conectar();	
	}
	private function query($sql) {
		$query = $this->db->query($sql);
		$this->db->close();
		return $query;
	}
	/** 
	 * Obtiene lista de oficinas-jefe ordenado por nombre
	 * @return {Object mysqli_result} $result
	 */
	public function getOficinasJefe() {
		$sql = "SELECT id, nombre FROM oficinas WHERE oficina_id IS NULL ORDER BY nombre";
		$result = $this->query($sql);
		return $result;
	}
	/**
	 * Obtiene lista de todas las oficinas
	 * @return {Object mysqli_result} $result
	 */
	public function getOficinasList() {
		$sql = "SELECT nombre, id, oficina_id FROM oficinas";
		$result = $this->query($sql);
		return $result;
	}
	/**
	 * Obtiene lista de suboficinas de una oficina-jefe
	 * @param {String} $id
	 * @return {Object mysqli_result} $result
	 */
	public function getSuboficinasEspecificas($id) {
		$sql = "SELECT id, nombre FROM oficinas WHERE oficina_id = $id";
		$result = $this->query($sql);
		return $result;
	}
	/**
	 * Obtiene lista de todas los cargos
	 * @return {Object mysqli_result} $result
	 */
	public function getCargosList($fecha_hoy) {
		$sql_trabajador_actual = "SELECT CONCAT(nombre, ' ', apellidos, '-', count(*)) FROM trabajadores 
				INNER JOIN contratos ON trabajadores.id = trabajador_id 
				WHERE cargo_id = c.id AND (fecha_salida > '$fecha_hoy' OR fecha_salida IS NULL)";

		$sqlMain = "SELECT c.id, nro_plaza, c.nombre AS cargo, o.nombre AS oficina, c.estado_presupuesto, ($sql_trabajador_actual) AS trabajador_actual
			FROM cargos AS c
			INNER JOIN oficinas AS o ON c.oficina_id = o.id";

		$result = $this->query($sqlMain);
		return $result;
	}
}

 ?>