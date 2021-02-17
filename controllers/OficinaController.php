<?php
class OficinaController extends ControladorBase {
	public function __construct() {
		parent::__construct();
	}

	public function mostrarFormulario() {
		require_once 'views/oficina/formulario.php';

		// Liberar cookies
		if(isset($_SESSION['oficina']['crear']))
			unset($_SESSION['oficina']['crear']);
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

			$resultado = $oficina->insertar();
			
			// Creación exitosa de una oficina
			if($resultado) {
				$id = $oficina->getId();
				$_SESSION['oficina']['crear'] = 'success';
				$url = '?controller=Oficina&action=mostrar&id='.$id;
				$this->redirect($url);
			}
			// Creación fallida de una oficina 
			else {
				$_SESSION['oficina']['crear'] = 'error';
				$url = '?controller=Oficina&action=mostrarFormulario';
				$this->redirect($url);
			}
		}
	}
	
	public function listar() {
		require_once 'views/oficina/lista.php';

		// Liberar cookies
		if(isset($_SESSION['oficina']['eliminar']))
			unset($_SESSION['oficina']['eliminar']);
	}

	public function mostrar() {

		if(isset($_GET['id'])) {
			$oficina = new Oficina();
			
			$id = intval($_GET['id']);
			$oficina->setId($id);
			$nombreTabla = $oficina->getTable();
			$resultado = $oficina->getById($id, $nombreTabla);

			// Consulta exitosa
			if($resultado && mysqli_num_rows($resultado) == 1) {
				$dato = mysqli_fetch_assoc($resultado);
				$oficina->setNombre($dato['nombre']);
				$oficina->setOficinaId($dato['oficina_id']);

				$is_oficina_jefe;
				$tipo_oficina = '';
				$suboficinas = [];
				$oficinaJefe = [];
				$cargos = [];
				
				// GETTING OFICINAS
				if($oficina->getOficinaId() === null) {	// Si es una oficina jefe, obtiene suboficinas
					// $oficina->reconectar();
					$resultado = $oficina->getSuboficinas();
					if(mysqli_num_rows($resultado) > 0) {
						while($data = mysqli_fetch_assoc($resultado)) {
							$nombre = my_mb_ucwords($data['nombre']);
							$id = $data['id'];
							$suboficinas[] = array('nombre' => $nombre, 'id' => $id);
						}
					} else
						$suboficinas = 'No hay suboficinas registradas todavía';
					$is_oficina_jefe = true;
					$tipo_oficina = 'Suboficina';
				}
				else {		// Si es suboficina, obtiene oficina-jefe
					$resultado = $oficina->getOficinaJefe();

					if(mysqli_num_rows($resultado) === 1) {
						$oficinaJefe = mysqli_fetch_assoc($resultado);
						$oficinaJefe['nombre'] = my_mb_ucwords($oficinaJefe['nombre']);
					}
					$is_oficina_jefe = false;
					$tipo_oficina = 'Oficina jefe';
				}
		
				// GETTING CARGOS INFORMATION
				$resultado = $oficina->getCargosCount();

				if(mysqli_num_rows($resultado) > 0) {
					while($data = mysqli_fetch_assoc($resultado)) {
						$data['nombre'] = my_mb_ucwords($data['nombre']);
						$cargos[] = $data;
					}
				} else
					$cargos = 'No hay cargos registrados todavía';
				require_once 'views/oficina/mostrar.php';
			} else { // No existe oficina
				$url = '?controller=Oficina&action=listar';
				$this->redirect($url);
			}
		}

		// Liberar cookies
		if(isset($_SESSION['oficina']['crear']))
			unset($_SESSION['oficina']['crear']);
		if(isset($_SESSION['oficina']['editar']))
			unset($_SESSION['oficina']['editar']);
	}

	// Edita y actualiza la información de una oficina.
	public function editar() {
		if(isset($_GET['id']) && isset($_POST['nombre'])) {
			$oficina = new Oficina();
			$id = $_GET['id'];
			$nuevo_nombre = limpiarCadena($_POST['nombre']);
			$nueva_oficina_id = isset($_POST['check']) && isset($_POST['oficina-jefe']) 
								? $_POST['oficina-jefe'] : null;
			
			// Obtener datos de oficina para su comparación
			$resultado = $oficina->getById($id, $oficina->getTable());
			while($data = mysqli_fetch_assoc($resultado)) {
				$oficina->setNombre($data['nombre']);
				$oficina->setOficinaId($data['oficina_id']);
			}

			$nueva_oficina = array(
				'nombre' => $nuevo_nombre, 
				'oficina_jefe' => $nueva_oficina_id
			);
			
			// Mientras haya cambio en los datos se actualiza los datos
			if($this->checkUpdates($nueva_oficina, $oficina)) {
				$nueva_oficina_id = is_null($nueva_oficina_id) ? 'null':$nueva_oficina_id;
				$oficina->setId($id);
				$oficina->setNombre($nuevo_nombre);
				$oficina->setOficinaId($nueva_oficina_id);
				
				$resultado = $oficina->actualizar();
				if($resultado)
					$_SESSION['oficina']['editar'] = 'success';
				else
					$_SESSION['oficina']['editar'] = 'error';
			} else // Ningún cambio
				$_SESSION['oficina']['editar'] = 'nothing';
			
			$url = '?controller=Oficina&action=mostrar&id='.$id;
			$this->redirect($url);
		}
	}
	// Elimina una oficina
	public function eliminar() {;
		if(isset($_GET['id'])) {
			$oficina = new Oficina();
			$id = $_GET['id'];
			$oficina->setId($id);
			$oficina->eliminar();

			$_SESSION['oficina']['eliminar'] = 'success';
			$url = '?controller=Oficina&action=listar';
			$this->redirect($url);
		}
	}

	/**
	 * Comprueba si los datos son iguales o diferentes al editar un cargo, si hay actualización devuelve TRUE
	 * @param {Array} $nueva_oficina
	 * @param {Object} $oficina 
	 * @return {Bool}
	 */
	private function checkUpdates($nueva_oficina, $oficina) {
		if($nueva_oficina['nombre'] !== $oficina->getNombre())
			return true;
		if($nueva_oficina['oficina_jefe'] !== $oficina->getOficinaId())
			return true;
		return false;
	}
}
 ?>