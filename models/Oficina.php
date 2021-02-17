<?php

class Oficina extends ModelBase {
	private $id, $nombre, $oficina_id;
	private $table;			// Nombre de la tabla

	public function __construct() {
		parent::__construct();
		$this->table = 'oficinas';
	}
	/////////////////////////////////////
	//////// Setters and Getters ////////
	public function setId($id) {
		$this->id = $id;
	}
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	public function setOficinaId($oficinaId) {
		$this->oficina_id = $oficinaId;
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
	// Obtener nombre de la tabla
	public function getTable() {
		return $this->table;
	}

	/////////////////////////////////////
	///////////// Consultas /////////////

	// Inserta una nueva oficina (SQL INSERT INTO)
	public function insertar() {
		$sql = "INSERT INTO $this->table (id, oficina_id, nombre)
				VALUES (null, $this->oficina_id, '$this->nombre')";
		$resultado = $this->query($sql);
		$this->asignarID($resultado);
		return $resultado;
	}
	
	// Actualiza una oficina (SQL UPDATE)
	public function actualizar() {
		$sql = "UPDATE $this->table
				SET nombre = '$this->nombre', oficina_id = $this->oficina_id
				WHERE id = $this->id";
		$resultado = $this->query($sql);
		return $resultado;
	}	
	
	// Actualiza una oficina (SQL DELETE)
	public function eliminar() {
		$sql = "DELETE FROM $this->table WHERE id = $this->id";
		$resultado = $this->query($sql);
		return $resultado;
	}
	
	// Obtiene lista de suboficinas de una oficina-jefe
	public function getSuboficinas() {
		$sql = "SELECT id, nombre FROM $this->table WHERE oficina_id = $this->id";
		return $this->query($sql);
	}
	
	// Obtiene oficina-jefe de una suboficina
	public function getOficinaJefe() {
		$sql = "SELECT jefe.id, jefe.nombre 
				FROM $this->table AS jefe 
				INNER JOIN $this->table AS sub ON jefe.id = sub.oficina_id 
				WHERE sub.id = $this->id";
		return $this->query($sql);
	}
	// Obtiene y contabiliza cargos de una oficina NOTE: PUT THIS ON CARGOS MODEL!!!
	public function getCargosCount() {
		$sql = "SELECT COUNT(nombre) AS cont, nombre 
				FROM cargos WHERE oficina_id = $this->id GROUP BY nombre";
		return $this->query($sql);
	}

	/////////////////////////////////////
	////////// Helper functions /////////
	/**
	 * Asigna ID después de una inserción similar a mysqli_last_id().
	 * @param {Bool} $resultadoInsert
	 */
	private function asignarID($resultadoInsert) {
		if($resultadoInsert)
			$this->id = $this->getOnlyId($this->table, 'nombre', $this->nombre);
	}
}
 ?>