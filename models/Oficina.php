<?php

class Oficina extends ModelBase {
	private $id, $nombre, $oficina_id;

	public function __construct() {
		parent::__construct();
	}

	/////////////////////////////////////
	//////// SETTERS AND GETTERS ////////
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	public function setOficinaId($oficinaId) {
		$this->oficina_id = $oficinaId;
	}
	public function getId() {
		return $this->id;
	}

	/////////////////////////////////////////////////////////////////////////
	/**
	 * Asigna ID después de una inserción similar a mysqli_last_id().
	 * @param {bool} $resultadoInsert
	 */
	private function asignarID($resultadoInsert) {
		if($resultadoInsert) {
			$this->reconectar();
			
			$sql = "SELECT id FROM oficinas WHERE nombre = '$this->nombre'";
			$resultado = $this->query($sql);

			if($resultado && mysqli_num_rows($resultado) == 1) {
				while($temp_id = mysqli_fetch_assoc($resultado))
					$this->id = $temp_id['id'];
			}
		}
	}
	/**
	 * MySQL Declaración INSERT
	 * @return {bool} $resultado 
	 */
	public function insertar() {
		$sql = "INSERT INTO oficinas VALUES(null, $this->oficina_id, '$this->nombre', null)";
		$resultado = $this->query($sql);
		$this->asignarID($resultado);
		return $resultado;
	}
}
 ?>