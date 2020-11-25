<?php
class OficinaController extends ControladorBase {
	public function __construct() {
		parent::__construct();
	}
	public function formularioOficina() {
		require_once 'views/oficina/formulario.php';
	}
	public function crearOficina() {

		// Condición general
		if(isset($_POST)) {
			$oficina = new Oficina();
			// Condición para crear Suboficina 
			if(isset($_POST['nombre']) && isset($_POST['check']) && isset($_POST['oficina'])) {
				$id_oficinaJefe = intval($_POST['oficina']);
				$oficina->setNombre(limpiarCadena($_POST['nombre']));
				$oficina->setOficinaId($id_oficinaJefe);
			} 
			// Condición para crear Oficina-jefe
			else if(isset($_POST['nombre'])) {
				$oficina->setNombre(limpiarCadena($_POST['nombre']));
				$oficina->setOficinaId('null');
			}
		} else
			// redirecionar();

		die();
	}
}
 ?>