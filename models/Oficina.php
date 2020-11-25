<?php

class Oficina extends ModelBase {
	private $id, $nombre, $oficina_id;

	public function __construct() {
		parent::__construct();
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	public function setOficinaId($oficinaId) {
		$this->oficinaId = $oficinaId;
	}

}
 ?>