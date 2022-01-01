<?php
class OficinaController extends ControladorBase {
	private $url = [
		'mostrar'	=> '?controller=Oficina&action=mostrar&id=',
		'formulario'=> '?controller=Oficina&action=mostrarFormulario',
		'listar'	=> '?controller=Oficina&action=listar',
		'editar'	=> '?controller=Oficina&action=editar&id='
	];
	public function __construct() {
		parent::__construct();
	}

	public function mostrarFormulario() {
		require 'views/oficina/formulario.php';

		// Liberar cookies
		if(isset($_SESSION['oficina']['crear']))
			unset($_SESSION['oficina']['crear']);
	}

	public function listar() {
		require_once 'views/oficina/lista.php';
		
		// Liberar cookies
		if(isset($_SESSION['oficina']['eliminar']))
			unset($_SESSION['oficina']['eliminar']);
	}

	public function crear() {
		if(isset($_POST['nombre'])) {
			$nueva_oficina = new Oficina();
			$nueva_oficina->setNombre(limpiarCadena($_POST['nombre']));
			
			// Condición para crear Suboficina u Oficina Jefe 
			if(isset($_POST['check']) && isset($_POST['oficina-jefe']))
				$nueva_oficina->setOficinaId($_POST['oficina-jefe']);
			else 
				$nueva_oficina->setOficinaId(null);

			$res = $nueva_oficina->insertar();
			if($res) {
				$id = $nueva_oficina->getId();
				$_SESSION['oficina']['crear'] = 'success';
				$this->redirect($this->url['mostrar'].$id);
			} 
			else {
				$_SESSION['oficina']['crear'] = 'error';
				$this->redirect($this->url['formulario']);
			}
		}
	}

	public function mostrar() {
		if(isset($_GET['id'])) {
			$id = $_GET['id'];
			$oficina = new Oficina();
			$oficina->setId($id);
			
			// Variable para guardar y mostrar los datos en la vista
			$show = [
				'oficina' => [
					'nombre' => '',
					'id'	 => $oficina->getId(),
					'header' => '',	
					'lista'  => []	// Puede ser lista de suboficinas u oficina_jefe o un msg. 
				],
				'cargo'	  => [
					'lista' => []
				]
			];
			
			$res = $oficina->getById($id, 'oficinas');
			if($res && mysqli_num_rows($res) === 1) {
				$dato = mysqli_fetch_assoc($res);
				$es_oficina_jefe = ($dato['oficina_id'] === null) ? true : false;  

				$show['oficina']['nombre'] = my_mb_ucwords($dato['nombre']);
				
				// Obtiene lista de suboficinas si es una oficina jefe
				if($es_oficina_jefe === true) {
					$show['oficina']['header'] = 'Suboficinas';
					$res = $oficina->getSuboficinas();
					if($res && mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_assoc($res)) {
							$show['oficina']['lista'][] = [
								'nombre' => my_mb_ucwords($row['nombre']),
								'id'	 => $row['id']
							];
						}
					} else $show['oficina']['lista'] = 'No hay suboficinas registradas todavía.';
				}
				// Si es una suboficina, obtiene la oficina jefe
				else {
					$show['oficina']['header'] = 'Oficina jefe';
					$res = $oficina->getOficinaJefe();
					if($res && mysqli_num_rows($res) === 1) {
						$data = mysqli_fetch_assoc($res);
						$show['oficina']['lista'][] = [
							'nombre' => my_mb_ucwords($data['nombre']),
							'id' 	 => $data['id']
						];
					}
				}
		
				// Obtiene lista de cargos de una oficina y el número de cargos que se repiten
				$res = $oficina->getCargosCount();
				if($res && mysqli_num_rows($res) > 0) {
					while($data = mysqli_fetch_assoc($res)) {
						$data['nombre'] = my_mb_ucwords($data['nombre']);
						$show['cargo']['lista'][] = $data;
					}
				} else $show['cargo']['lista'] = 'No hay cargos registrados todavía.';

				require_once 'views/oficina/mostrar.php';
			} else { 	// No existe oficina
				$this->redirect($this->url['listar']);
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
			$id = $_GET['id'];
			$nueva_oficina_id = isset($_POST['check']) && isset($_POST['oficina-jefe']) 
								? $_POST['oficina-jefe'] : null;
		
			$update_oficina = array(
				'nombre' => limpiarCadena($_POST['nombre']),
				'oficina_jefe' => $nueva_oficina_id
			);

			// Obtener datos de oficina para su comparación
			$oficina = new Oficina();
			$res = $oficina->getById($id, 'oficinas');
			while($data = mysqli_fetch_assoc($res)) {
				$oficina->setNombre($data['nombre']);
				$oficina->setOficinaId($data['oficina_id']);
			}

			// Mientras haya algún cambio se actualiza los datos
			if($this->anyChanges($update_oficina, $oficina)) {
				$oficina->setId($id);
				$oficina->setNombre($update_oficina['nombre']);
				$oficina->setOficinaId($update_oficina['oficina_jefe']);
				
				$res = $oficina->actualizar();
				$_SESSION['oficina']['editar'] = ($res) ? 'success' : 'error';
				/*if($res) $_SESSION['oficina']['editar'] = 'success';
				else $_SESSION['oficina']['editar'] = 'error';*/
			} else 
				$_SESSION['oficina']['editar'] = 'info'; // Ningún cambio
			
			$this->redirect($this->url['mostrar'].$id);
		}
	}
	// Elimina una oficina
	public function eliminar() {;
		if(isset($_GET['id'])) {
			$id = $_GET['id'];
			
			$oficina = new Oficina();
			$oficina->setId($id);
			$oficina->eliminar();

			$_SESSION['oficina']['eliminar'] = 'success';
			$this->redirect($this->url['listar']);
		}
	}

	/**
	 * Comprueba si los datos son iguales o diferentes al editar un cargo, si hay cambios devuelve TRUE
	 * @param{Array} nueva_oficina
	 * @param{Object} oficina 
	 * @return{Bool}
	 */
	private function anyChanges($nueva_oficina, $oficina) {
		if($nueva_oficina['nombre'] !== $oficina->getNombre())
			return true;
		if($nueva_oficina['oficina_jefe'] !== $oficina->getOficinaId())
			return true;
		return false;
	}
}
 ?>