<?php
class OficinaController extends ControladorBase {
	public function __construct() {
		parent::__construct();
	}
	public function mostrarFormulario() {
		require_once 'views/oficina/formulario.php';

		// Liberar cookies
		if(isset($_SESSION['oficina']['crearOficina']))
			unset($_SESSION['oficina']['crearOficina']);
	}
	public function crear() {

		// Condición general
		if(isset($_POST['nombre'])) {
			$oficina = new Oficina();

			$oficina->setNombre(limpiarCadena($_POST['nombre']));
			
			// Condición para crear Suboficina u Oficina Jefe 
			if(isset($_POST['check']) && isset($_POST['oficina-jefe']))
				$oficina->setOficinaId(intval($_POST['oficina-jefe']));
			else 
				$oficina->setOficinaId('null');

			$exito = $oficina->insertar();
			
			// Consulta exitosa
			if($exito) {
				$id = strval($oficina->getId());
				$_SESSION['oficina']['crearOficina'] = 'success';
				header("Location: ?controller=Oficina&action=mostrar&id=".$id);
			}	// Consulta fallida
			else {
				$_SESSION['oficina']['crearOficina'] = 'unsuccess';
				header("Location: ?controller=Oficina&action=mostrarFormulario");
			}
		}
	}
	public function listar() {
		require_once 'views/oficina/lista.php';
	}
	public function mostrar() {
		require_once 'views/oficina/mostrar.php';

		// Liberar cookies
		if(isset($_SESSION['oficina']['crearOficina']))
			unset($_SESSION['oficina']['crearOficina']);

	}
}
 ?>