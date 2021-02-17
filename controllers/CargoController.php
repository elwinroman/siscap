<?php
class CargoController extends ControladorBase {
	public function mostrarFormulario() {
		require 'views/cargo/formulario.php';

		// Liberar cookies
		if(isset($_SESSION['cargo']['crear']))
			unset($_SESSION['cargo']['crear']);
	}
	public function crear() {

		if(isset($_POST['nombre']) && isset($_POST['nro-plaza']) && isset($_POST['oficina-jefe']) && isset($_POST['cargo-confianza']) && isset($_POST['cargo-jefe'])) {

			$cargo = new Cargo();

			$datos = array(
				'nombre' => limpiarCadena($_POST['nombre']),
				'nroPlaza' => $_POST['nro-plaza'],
				'idOficinaJefe' => $_POST['oficina-jefe'],
				'cargoConfianza' => $_POST['cargo-confianza'],
				'cargoJefe' => $_POST['cargo-jefe']
			);

			// Setear datos
			$cargo->setNombre($datos['nombre']);
			$cargo->setNroPlaza($datos['nroPlaza']);
			$cargo->setCargoConfianza($datos['cargoConfianza']);
			$cargo->setCargoJefe($datos['cargoJefe']);

			// Si el cargo pertenece a una suboficina se envia el id de la suboficina
			if(isset($_POST['check']) && isset($_POST['suboficina'])) {
				$idSuboficina = $_POST['suboficina'];
				$cargo->setOficinaId($idSuboficina);
			} 
			else 	// Se envia el id de la oficina-jefe
				$cargo->setOficinaId($datos['idOficinaJefe']);
			
			$resultado = $cargo->insertar();
			if($resultado) {
				$id = $cargo->getId();
				$_SESSION['cargo']['crear'] = 'success';
				$url = '?controller=Cargo&action=mostrar&id='.$id;
				$this->redirect($url);
			} else {
				$_SESSION['cargo']['crear'] = 'error';
				$url = '?controller=Cargo&action=mostrarFormulario';
				$this->redirect($url);
			}
		}
	}
	public function mostrar() {
		if(isset($_GET['id'])) {
			$cargo = new Cargo();

			$id = $_GET['id'];
			$cargo->setId($id);
			$nombreTabla = $cargo->getTable();

			$resultado = $cargo->getById($id, $nombreTabla);

			// Obtener atributos del cargo
			if($resultado && mysqli_num_rows($resultado) == 1) {
				$dato = mysqli_fetch_assoc($resultado);
				$cargo->setNombre($dato['nombre']);
				$cargo->setNroPlaza($dato['nro_plaza']);
				$cargo->setOficinaId($dato['oficina_id']);
				$cargo->setCargoConfianza($dato['cargo_confianza']);
				$cargo->setCargoJefe($dato['cargo_jefe']);
				$cargo->setEstadoPresupuesto($dato['estado_presupuesto']);
			
				// Obtener trabajador actual
				$trabajadorActual = $cargo->getTrabajadorActual();
				if($trabajadorActual) {
					if(mysqli_num_rows($trabajadorActual) == 1) {
						$data = mysqli_fetch_row($trabajadorActual); 
						$trabajador = my_mb_ucwords($data[0]);
					} else
						$trabajador = 'Vacante';
				}

				// Obtener nombre de la oficina
				$oficinaName = "unknown";
				$oficina = new Oficina();
				$idOficina = $cargo->getOficinaId();
				$nombreTabla = $oficina->getTable();
				$resultado = $oficina->getById($idOficina, $nombreTabla);
				if($resultado && mysqli_num_rows($resultado) == 1) {
					$dato = mysqli_fetch_assoc($resultado);
					$oficinaName = my_mb_ucwords($dato['nombre']);
					// $oficina->setNombre($dato['nombre']);
					$oficina->setId($dato['id']);
					$oficina->setOficinaId($dato['oficina_id']);
				}

				$oficinas_data = array(
					'oficina' => null,
					'suboficina' => null 
				);
				// Obtener oficinas o suboficinas dependiendo
				if($oficina->getOficinaId() === null) {
					$oficinas_data['oficina'] = $cargo->getOficinaId();
				} else {
					$oficinaJefeData = $oficina->getOficinaJefe();
					if(mysqli_num_rows($oficinaJefeData) === 1) {
						$oficina_jefe = mysqli_fetch_assoc($oficinaJefeData);
						$oficinas_data['oficina'] = $oficina_jefe['id'];
					}
					$oficinas_data['suboficina'] = $cargo->getOficinaId();
				}
				require_once 'views/cargo/mostrar.php';
			} else {	// No existe cargo
				$url = '?controller=Cargo&action=listar';
				$this->redirect($url);
			}
		}

		// Liberar cookies
		if(isset($_SESSION['cargo']['crear']))
			unset($_SESSION['cargo']['crear']);
		if(isset($_SESSION['cargo']['editar']))
			unset($_SESSION['cargo']['editar']);
	}
	public function listar() {
		require_once 'views/cargo/lista.php';

		// Liberar cookies
		if(isset($_SESSION['cargo']['eliminar']))
			unset($_SESSION['cargo']['eliminar']);
	}
	public function editar() {
		if(isset($_GET['id']) && isset($_POST['nombre']) && isset($_POST['nro-plaza']) && isset($_POST['oficina-jefe']) && isset($_POST['cargo-confianza']) && isset($_POST['cargo-jefe'])) {

			$cargo = new Cargo();
			$id = $_GET['id'];

			// Obtener datos de cargo para su comparación
			$resultado = $cargo->getById($id, $cargo->getTable());
			while($data = mysqli_fetch_assoc($resultado)) {
				$cargo->setNombre($data['nombre']);
				$cargo->setNroPlaza($data['nro_plaza']);
				$cargo->setOficinaId($data['oficina_id']);
				$cargo->setCargoJefe($data['cargo_jefe']);
				$cargo->setCargoConfianza($data['cargo_confianza']);
			}

			$nuevo_cargo = array(
				'nombre' => limpiarCadena($_POST['nombre']),
				'nro_plaza' => $_POST['nro-plaza'],
				'oficina_id' => $_POST['oficina-jefe'],
				'cargo_confianza' => intval($_POST['cargo-confianza']),
				'cargo_jefe' => intval($_POST['cargo-jefe'])
			);

			// Si el cargo pertenece a una suboficina 
			if(isset($_POST['check']) && isset($_POST['suboficina'])) {
				$id_suboficina = $_POST['suboficina'];
				$nuevo_cargo['oficina_id'] = $id_suboficina;
			}

			// Si hay cambios en los datos, se realiza la actualización
			if($this->checkUpdates($nuevo_cargo, $cargo)) {
				$cargo->setId($id);
				$cargo->setNombre($nuevo_cargo['nombre']);
				$cargo->setNroPlaza($nuevo_cargo['nro_plaza']);
				$cargo->setOficinaId($nuevo_cargo['oficina_id']);
				$cargo->setCargoConfianza($nuevo_cargo['cargo_confianza']);
				$cargo->setCargoJefe($nuevo_cargo['cargo_jefe']);
				
				$resultado = $cargo->actualizar();
				if($resultado)
					$_SESSION['cargo']['editar'] = 'success';
				else
					$_SESSION['cargo']['editar'] = 'error';	

			} else 	// Ningún cambio
				$_SESSION['cargo']['editar'] = 'nothing';
			
			$url = '?controller=Cargo&action=mostrar&id='.$id;
			$this->redirect($url);
		}
	}

	// Elimina un cargo
	public function eliminar() {;
		if(isset($_GET['id'])) {
			$cargo = new Cargo();
			$id = $_GET['id'];
			$cargo->setId($id);
			$cargo->eliminar();

			$_SESSION['cargo']['eliminar'] = 'success';
			$url = '?controller=Cargo&action=listar';
			$this->redirect($url);
		}
	}

	private function checkUpdates($nuevo_cargo, $cargo) {
		if($nuevo_cargo['nombre'] !== $cargo->getNombre())
			return true;
		if($nuevo_cargo['nro_plaza'] !== $cargo->getNroPlaza())
			return true;
		if($nuevo_cargo['oficina_id'] !== $cargo->getOficinaId())
			return true;
		if($nuevo_cargo['cargo_confianza'] !== $cargo->getCargoConfianza())
			return true;
		if($nuevo_cargo['cargo_jefe'] !== $cargo->getCargoJefe())
			return true;
		return false;
	}
}
 ?>