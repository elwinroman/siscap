<?php 

class Contrato extends ModelBase {
	private $id, $trabajador_id, $cargo_id, $fecha_entrada, $fecha_salida, $condicion;
	private $table;

	public function __construct() {
		parent::__construct();
		$this->table = 'Contratos';
	}

	//////////////// Querys DB ////////////////

	// Inserta un nuevo contrato (SQL INSERT INTO)
	public function insertar() {
		$query = "INSERT INTO 'contratos' (id, trabajador_id, cargo_id, fecha_salida, condicion)
				  VALUES(?, ?, ?, ?, ?, ?)";
		$data = [null, $this->trabajador_id, $this->cargo_id, $this->fecha_entrada, $this->fecha_salida, $this->condicion];
		$res = $this->preparedQuery($query, $data);
		return $res;
	}

	/**
	 * Obtiene historial de contrato de un cargo
	 * @param{String} cargo_id
	 */
	public function obtenerHistorialCargo($cargo_id) {
		$query = "SELECT * FROM contratos WHERE cargo_id = $cargo_id";
		$res = $this->query($query);
		return $res;
	}

	//////////////// Setters & Getters ////////////////
	public function setId($id) {
		$this->id = $id;
	}
	public function setTrabajadorId($trabajador_id) {
		$this->trabajador_id = $trabajador_id;
	}
	public function setCargoId($cargo_id) {
		$this->cargo_id = $cargo_id;
	}
	public function setFechaEntrada($fecha_entrada) {
		$this->fecha_entrada = $fecha_entrada;
	}
	public function setFechaSalida($fecha_salida) {
		$this->fecha_salida = $fecha_salida;
	}
	public function setCondicion($condicion) {
		$this->condicion = $condicion;
	}
	public function getId() {
		return $this->id;
	}
	public function getTrabajadorId() {
		return $this->trabajador_id;
	}
	public function getCargoId() {
		return $this->cargo_id;
	}
	public function getFechaEntrada() {
		return $this->fecha_entrada;
	}
	public function getFechaSalida() {
		return $this->fecha_salida;
	}
	public function getCondicion() {
		return $this->condicion;
	}
}

 ?>