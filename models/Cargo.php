<?php

class Cargo extends ModelBase {
	private $id, $nombre, $oficina_id, $nro_plaza, $cargo_confianza;
	private $cargo_jefe, $estado_presupuesto;
	private $table; // nombre de la tabla

	public function __construct() {
		parent::__construct();
		$this->table = 'cargos';
	}
	//////////////// Querys DB ////////////////

	// Inserta un nuevo cargo (SQL INSERT INTO)
	public function insertar() {
		$query = 'INSERT INTO cargos (id, oficina_id, nro_plaza, nombre, cargo_confianza, cargo_jefe) 
					VALUES (?, ?, ?, ?, ?, ?)';
		$data = [null, $this->oficina_id, $this->nro_plaza, $this->nombre, 
					$this->cargo_confianza, $this->cargo_jefe];
		$res = $this->preparedQuery($query, $data);
		$this->id = intval($this->getOnlyId('cargos', 'nro_plaza', $this->nro_plaza));
		return $res;
	}

	// Actualiza un cargo (SQL UPDATE)
	public function actualizar() {
		$query = 'UPDATE cargos SET oficina_id=?, nro_plaza=?, nombre=?, cargo_confianza=?, cargo_jefe=? WHERE id=?';
		$data = [$this->oficina_id, $this->nro_plaza, $this->nombre, $this->cargo_confianza, $this->cargo_jefe, $this->id];
		$res = $this->preparedQuery($query, $data);
		return $res;
	}
	// Elimina un cargo (SQL DELETE)
	public function eliminar() {
		$sql = "DELETE FROM $this->table WHERE id = $this->id";
		$resultado = $this->query($sql);
		return $resultado;
	}
	// Obtener el trabajador actual del cargo
	public function getTrabajadorActual() {
		$sql = "SELECT CONCAT(nombre, ' ', apellido) AS worker 
				FROM trabajadores 
				INNER JOIN contratos ON trabajadores.id = trabajador_id 
				WHERE cargo_id = $this->id 
					AND (fecha_salida > CURRENT_DATE() OR fecha_salida IS NULL)";
		$res = $this->query($sql);
		return $res;
	}

	//////////////// Setters & Getters ////////////////
	public function setId($id) {
		$this->id = intval($id);
	}
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	public function setOficinaId($oficinaId) {
		$this->oficina_id = intval($oficinaId);
	}
	public function setNroPlaza($nro_plaza) {
		$this->nro_plaza = $nro_plaza;
	}
	public function setCargoConfianza($cargo_confianza) {
		$this->cargo_confianza = intval($cargo_confianza);
	}
	public function setCargoJefe($cargo_jefe) {
		$this->cargo_jefe = intval($cargo_jefe);
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
	public function getTable() {
		return $this->table;
	}
}
 ?>