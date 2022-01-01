<?php 

class AjaxModel {
	private $database, $db;

	public function __construct() {
		require '../config/bd.php';
		$this->db = new Database();
		$this->conn = $this->db->connect();
	}
	private function query($query) {
		$res = $this->conn->query($query);
		$this->conn->close();
		return $res;
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
	public function listarOficinas() {
		$sql = "SELECT nombre, id, oficina_id FROM oficinas ORDER BY nombre";
		$res = $this->query($sql);
		return $res;
	}
	/**
	 * Obtiene lista de suboficinas de una oficina-jefe
	 * @param {String} $id
	 * @return {Object mysqli_result} $result
	 */
	public function getSuboficinas($id) {
		$sql = "SELECT id, nombre FROM oficinas WHERE oficina_id = $id";
		$result = $this->query($sql);
		return $result;
	}
	/**
	 * Obtiene lista de todas los cargos
	 * @return {Object mysqli_result} $result
	 */
	public function listarCargos($fecha_hoy) {
		$sql_trabajador_actual = "SELECT CONCAT(nombre, ' ', apellido) FROM trabajadores 
				INNER JOIN contratos ON trabajadores.id = trabajador_id 
				WHERE cargo_id = c.id AND (fecha_salida > '$fecha_hoy' OR fecha_salida IS NULL)";

		$sqlMain = "SELECT c.id, nro_plaza, c.nombre AS cargo, o.nombre AS oficina, c.estado_presupuesto, ($sql_trabajador_actual) AS trabajador_actual, c.cargo_confianza, c.cargo_jefe
			FROM cargos AS c
			INNER JOIN oficinas AS o ON c.oficina_id = o.id ORDER BY nro_plaza";

		/*$sql = "SELECT cargos.nro_plaza, cargos.nombre, contratos.trabajador_id, oficinas.nombre FROM cargos 
				LEFT JOIN contratos ON cargos.id = contratos.cargo_id
				LEFT JOIN oficinas ON cargos.oficina_id = oficinas.id
				WHERE (CURRENT_DATE < contratos.fecha_salida OR contratos.fecha_salida IS NULL)";*/

		$res = $this->query($sqlMain);
		return $res;
	}
	/**
	 * Establece un valor 0 o 1 en el estado de presupuest de un cargo
	 * @param {String} $id_cargo
	 * @param {String} $new_status
	 */
	public function cambiarEstadoPresupuesto($id_cargo, $new_status) {
		$sql = "UPDATE cargos SET estado_presupuesto = $new_status WHERE id = $id_cargo";
		$result = $this->query($sql);
		return $result;
	}

	// Obtiene cargos vacantes
	public function getCargosVacantes() {
		$sql = "SELECT c.id, c.nro_plaza, c.nombre, contratos.trabajador_id FROM cargos AS c 
				LEFT JOIN contratos ON c.id = contratos.cargo_id 
				WHERE (CURRENT_DATE < contratos.fecha_salida OR contratos.fecha_salida IS NULL) 
					AND contratos.trabajador_id IS NULL
				ORDER BY c.nro_plaza";
		$resultado = $this->query($sql);
		return $resultado;
	}

}

 ?>