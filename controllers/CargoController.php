<?php 
class CargoController extends ControladorBase {
	public function mostrarFormulario() {
		require 'views/cargo/formulario.php';
	}
	public function crear() {
		var_dump($_POST);

		if(isset($_POST['nombre']) && isset($_POST['nro-plaza']) && isset($_POST['oficina-jefe']) && isset($_POST['cargo-confianza']) && isset($_POST['cargo-jefe'])) {
			
			// $cargo = new Cargo();

			$datos = array(
				'nombre' => limpiarCadena($_POST['nombre']),
				'nroPlaza' => $_POST['nro-plaza'],
				'idOficinaJefe' => $_POST['oficina-jefe']			
			);

			// Setear datos
			// $cargo->setNombre($datos['nombre']);
			// $cargo->setNroPlaza($datos['nroPlaza']);

			// Si el cargo pertenece a una suboficina se envia el id de la suboficina
			if(isset($_POST['check']) && isset($_POST['suboficina'])) {
				// $idSuboficina = $_POST['suboficina'];
				$datos[] = array('idSuboficina' => $_POST['suboficina']);
				// $cargo->setOficinaId($datos['idSuboficina']);
			} else 	// Se envia el id de la oficina-jefe
				// $cargo->setOficinaId($datos['idOficinaJefe']);

			$cargo->insertar();
		echo "<br>#####################################################<br>";
		var_dump($datos);
		}

	}
	public function listar() {
		require_once 'views/cargo/lista.php';
	}


}
 ?>