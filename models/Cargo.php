<?php

class Cargo extends ModelBase {
	private $id, $nombre, $oficina_id, $nro_plaza;
	private $cargo_confianza, $cargo_jefe, $estado_presupuesto;		// booleanos
	private $table;			// Nombre de la tabla

	public function __construct() {
		parent::__construct();
		$this->table = 'cargos';
	}
	/////////////////////////////////////
	//////// SETTERS AND GETTERS ////////
	public function setId($id) {
		$this->id = $id;
	}
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	public function setOficinaId($oficinaId) {
		$this->oficina_id = $oficinaId;
	}
	public function setNroPlaza($nro_plaza) {
		$this->nro_plaza = $nro_plaza;
	}
	public function setCargoConfianza($cargo_confianza) {
		$this->cargo_confianza = $cargo_confianza;
	}
	public function setCargoJefe($cargo_jefe) {
		$this->cargo_jefe = $cargo_jefe;
	}
	public function setEstadoPresupuesto($estado_presupuesto) {
		$this->estado_presupuesto = $estado_presupuesto;
	}

	public function getId() {
		return $this->id;
	}
	public function getNombre() {
		return $this->nombre;
	}
	public function getNroPlaza() {
		return $this->nro_plaza;
	}
	public function getOficinaId() {
		return $this->oficina_id;
	}
	public function getCargoConfianza() {
		return intval($this->cargo_confianza);
	}
	public function getCargoJefe() {
		return intval($this->cargo_jefe);
	}
	public function getEstadoPresupuesto() {
		return intval($this->estado_presupuesto);
	}
	// Obtener nombre de la tabla
	public function getTable() {
		return $this->table;
	}

	// Inserta un nuevo cargo (SQL INSERT INTO)
	public function insertar() {
		$sql = "INSERT INTO $this->table (id, oficina_id, nro_plaza, 
										nombre, cargo_confianza, cargo_jefe)
				VALUES (null, $this->oficina_id, '$this->nro_plaza', '$this->nombre', 
						$this->cargo_confianza, $this->cargo_jefe)";
		$resultado = $this->query($sql);
		$this->asignarID($resultado);
		return $resultado;
	}

	// Actualiza un cargo (SQL UPDATE)
	public function actualizar() {
		$sql = "UPDATE $this->table
				SET oficina_id = $this->oficina_id, nro_plaza = '$this->nro_plaza', 
					nombre = '$this->nombre', cargo_confianza = $this->cargo_confianza, 
					cargo_jefe = $this->cargo_jefe
				WHERE id = $this->id";
		$resultado = $this->query($sql);
		return $resultado;
	}

	// Elimina un cargo (SQL DELETE)
	public function eliminar() {
		$sql = "DELETE FROM $this->table WHERE id = $this->id";
		$resultado = $this->query($sql);
		return $resultado;
	}

	public function getTrabajadorActual() {
		$current_date = date("Y-m-d");
		$sql = "SELECT CONCAT(nombre, ' ',apellidos) AS worker 
				FROM trabajadores 
				INNER JOIN contratos ON trabajadores.id = trabajador_id 
				WHERE cargo_id = $this->id 
					AND (fecha_salida > '$current_date' OR fecha_salida IS NULL)";
		$resultado = $this->query($sql);

		return $resultado;
	}

	////////// Helper functions /////////
	/**
	 * Asigna ID después de una inserción similar a mysqli_last_id().
	 * @param {Bool} $resultadoInsert
	 */
	private function asignarID($resultadoInsert) {
		if($resultadoInsert) {
			$this->id = $this->getOnlyId($this->table, 'nro_plaza', $this->nro_plaza);
		}
	}
}
 ?>