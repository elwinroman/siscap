<?php

class Oficina extends ModelBase {
	private $id, $nombre, $oficina_id;

	public function __construct() {
		parent::__construct();
	}
	//////////////// Querys DB ////////////////
	
	// Inserta una nueva oficina (SQL INSERT INTO)
	public function insertar() {
		$query = 'INSERT INTO oficinas (id, oficina_id, nombre) VALUES (?, ?, ?)';
		$data = [null, $this->oficina_id, $this->nombre];
		$res = $this->preparedQuery($query, $data);
		$this->id = intval($this->getOnlyId('oficinas', 'nombre', $this->nombre));
		return $res;
	}
	// Actualiza una oficina (SQL UPDATE)
	public function actualizar() {
		$query = 'UPDATE oficinas SET nombre=?, oficina_id=? WHERE id=?';
		$data = [$this->nombre, $this->oficina_id, $this->id];
		$res = $this->preparedQuery($query, $data);
		return $res;
	}	
	// Actualiza una oficina (SQL DELETE)
	public function eliminar() {
		$sql = "DELETE FROM oficinas WHERE id = $this->id";
		$resultado = $this->query($sql);
		return $resultado;
	}
	// Obtiene lista de suboficinas de una oficina-jefe
	public function getSuboficinas() {
		$sql = "SELECT id, nombre FROM oficinas WHERE oficina_id = $this->id";
		return $this->query($sql);
	}
	// Obtiene oficina-jefe de una suboficina
	public function getOficinaJefe() {
		$sql = "SELECT jefe.id, jefe.nombre 
				FROM oficinas AS jefe 
				INNER JOIN oficinas AS sub ON jefe.id = sub.oficina_id 
				WHERE sub.id = $this->id";
		return $this->query($sql);
	}
	// Obtiene y contabiliza cargos de una oficina
	public function getCargosCount() {
		$sql = "SELECT COUNT(nombre) AS cont, nombre 
				FROM cargos WHERE oficina_id = $this->id GROUP BY nombre";
		return $this->query($sql);
	}

	//////////////// Setters & Getters ////////////////
	public function setId($id) {
		$this->id = intval($id);
	}
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	public function setOficinaId($oficina_id) {
		$this->oficina_id = ($oficina_id === null) ? null : intval($oficina_id);
	}
	public function getId() {
		return $this->id;
	}
	public function getNombre() {
		return $this->nombre;
	}
	public function getOficinaId() {
		return $this->oficina_id;
	}
}
 ?>