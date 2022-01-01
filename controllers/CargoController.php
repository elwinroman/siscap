<?php
class CargoController extends ControladorBase {
	private $url = [
		'mostrar'	=> '?controller=Cargo&action=mostrar&id=',
		'formulario'=> '?controller=Cargo&action=mostrarFormulario',
		'listar'	=> '?controller=Cargo&action=listar',
		'editar'	=> '?controller=Cargo&action=editar&id='
	];
	public function __construct() {
		parent::__construct();
	}

	public function mostrarFormulario() {
		require 'views/cargo/formulario.php';

		// Liberar cookies
		if(isset($_SESSION['cargo']['crear']))
			unset($_SESSION['cargo']['crear']);
	}

	public function listar() {
		require_once 'views/cargo/lista.php';

		// Liberar cookies
		if(isset($_SESSION['cargo']['eliminar']))
			unset($_SESSION['cargo']['eliminar']);

	}
	public function crear() {
		if(isset($_POST['nombre']) && isset($_POST['nro-plaza']) && isset($_POST['oficina-jefe']) && isset($_POST['cargo-confianza']) && isset($_POST['cargo-jefe'])) {

			// Envia el ID dependiendo de si es oficina-jefe o es una suboficina
			if(isset($_POST['check']) && isset($_POST['suboficina']))
				$oficina_id = $_POST['suboficina'];
			else
				$oficina_id = $_POST['oficina-jefe'];

			$datos_cargo = array(
				'nombre' 		=> limpiarCadena($_POST['nombre']),
				'nro_plaza'		=> $_POST['nro-plaza'],
				'oficina_id' 	=> $oficina_id,
				'cargo_confianza' => $_POST['cargo-confianza'],
				'cargo_jefe'	=> $_POST['cargo-jefe']
			);

			// Setear datos
			$new_cargo = new Cargo();
			$new_cargo->setNombre($datos_cargo['nombre']);
			$new_cargo->setNroPlaza($datos_cargo['nro_plaza']);
			$new_cargo->setCargoConfianza($datos_cargo['cargo_confianza']);
			$new_cargo->setCargoJefe($datos_cargo['cargo_jefe']);
			$new_cargo->setOficinaId($datos_cargo['oficina_id']);

			// Crear un nuevo cargo en la base de datos
			$res = $new_cargo->insertar();
			if($res) {
				$_SESSION['cargo']['crear'] = 'success';
				$id = $new_cargo->getId();
				$this->redirect($this->url['mostrar'].$id);
			} else {
				$_SESSION['cargo']['crear'] = 'error';
				$this->redirect($this->url['formulario']);
			}
		}
	}
	public function mostrar() {
		if(isset($_GET['id'])) {
			$id = $_GET['id'];
			$cargo = new Cargo();
			$cargo->setId($id);

			// Variable para guardar y mostrar los datos en la vista
			$show = [
				'cargo' => [
					'id'	 	=> $id,
					'nombre' 	=> '',
					'nro_plaza' => '',	
					'confianza'  => '',
					'jefe'		=> ''  ,
					'presupuesto' => '',
					'trabajador_actual' => '',
					'oficina'	=> ''		// oficina al que pertenece el cargo
				],
				'oficina' => [
					'oficina_jefe' => '',
					'suboficina' => null
				]
			];

			$res = $cargo->getById($id, 'cargos');
			if($res && mysqli_num_rows($res) === 1) {
				$dato_cargo = mysqli_fetch_assoc($res);
				$show['cargo']['nombre'] = my_mb_ucwords($dato_cargo['nombre']);
				$show['cargo']['nro_plaza'] = $dato_cargo['nro_plaza'];
				$show['cargo']['confianza'] = intval($dato_cargo['cargo_confianza']);
				$show['cargo']['jefe'] = intval($dato_cargo['cargo_jefe']);
				$show['cargo']['presupuesto'] = $dato_cargo['estado_presupuesto'];
				
				// Obtener trabajador actual
				$trabajador_actual = $cargo->getTrabajadorActual();
				if($trabajador_actual) {
					if(mysqli_num_rows($trabajador_actual) == 1) {
						$data = mysqli_fetch_row($trabajador_actual); 
						$show['cargo']['trabajador_actual'] = my_mb_ucwords($data[0]);
					} else
						$show['cargo']['trabajador_actual'] = 'Vacante';
				}

				// Obtener nombre de la oficina
				$oficina_id = intval($dato_cargo['oficina_id']);
				$oficina = new Oficina();

				$res = $oficina->getById($oficina_id, 'oficinas');
				if($res && mysqli_num_rows($res) === 1) {
					$dato_oficina = mysqli_fetch_assoc($res);
					$show['cargo']['oficina'] = my_mb_ucwords($dato_oficina['nombre']);
					
					$oficina->setId($dato_oficina['id']);
					$oficina->setOficinaId($dato_oficina['oficina_id']);
				}	
				
				// Obtener oficina y/o suboficina para el MODAL editar
				if($oficina->getOficinaId() === null) {
					$show['oficina']['oficina_jefe'] = $oficina_id;
				} else {
					$res = $oficina->getOficinaJefe();
					if(mysqli_num_rows($res) === 1) {
						$data_oficina_jefe = mysqli_fetch_assoc($res);
						$show['oficina']['oficina_jefe'] = $data_oficina_jefe['id'];
					} else die('error');
					$show['oficina']['suboficina'] = $oficina_id;
				}
				require_once 'views/cargo/mostrar.php';
			} else 	// No existe cargo
				$this->redirect($this->url['listar']);
		}

		// Liberar cookies
		if(isset($_SESSION['cargo']['crear']))
			unset($_SESSION['cargo']['crear']);
		if(isset($_SESSION['cargo']['editar']))
			unset($_SESSION['cargo']['editar']);
	}
	public function editar() {
		if(isset($_GET['id']) && isset($_POST['nombre']) && isset($_POST['nro-plaza']) && isset($_POST['oficina-jefe']) && isset($_POST['cargo-confianza']) && isset($_POST['cargo-jefe'])) {

			$cargo = new Cargo();
			$id = $_GET['id'];

			// Obtener datos de cargo para su comparación
			$res = $cargo->getById($id, $cargo->getTable());
			while($data = mysqli_fetch_assoc($res)) {
				$cargo->setNombre($data['nombre']);
				$cargo->setNroPlaza($data['nro_plaza']);
				$cargo->setOficinaId($data['oficina_id']);
				$cargo->setCargoJefe($data['cargo_jefe']);
				$cargo->setCargoConfianza($data['cargo_confianza']);
			}

			$update_cargo = array(
				'nombre' 	=> limpiarCadena($_POST['nombre']),
				'nro_plaza' => $_POST['nro-plaza'],
				'oficina_id'=> intval($_POST['oficina-jefe']),
				'cargo_confianza' => intval($_POST['cargo-confianza']),
				'cargo_jefe' => intval($_POST['cargo-jefe'])
			);

			// Si el cargo pertenece a una suboficina 
			if(isset($_POST['check']) && isset($_POST['suboficina'])) {
				$id_suboficina = $_POST['suboficina'];
				$update_cargo['oficina_id'] = $id_suboficina;
			}

			// Si hay cambios en los datos, se realiza la actualización
			if($this->checkUpdates($update_cargo, $cargo)) {
				$cargo->setId($id);
				$cargo->setNombre($update_cargo['nombre']);
				$cargo->setNroPlaza($update_cargo['nro_plaza']);
				$cargo->setOficinaId($update_cargo['oficina_id']);
				$cargo->setCargoConfianza($update_cargo['cargo_confianza']);
				$cargo->setCargoJefe($update_cargo['cargo_jefe']);
				
				$res = $cargo->actualizar();
				$_SESSION['cargo']['editar'] = ($res) ? 'success' : 'error';
			} else 	// Ningún cambio
				$_SESSION['cargo']['editar'] = 'info';
			$this->redirect($this->url['mostrar'].$id);
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
			$this->redirect($this->url['listar']);
		}
	}

	private function checkUpdates($update_cargo, $cargo) {
		if($update_cargo['nombre'] !== $cargo->getNombre())
			return true;
		if($update_cargo['nro_plaza'] !== $cargo->getNroPlaza())
			return true;
		if($update_cargo['oficina_id'] !== $cargo->getOficinaId())
			return true;
		if($update_cargo['cargo_confianza'] !== $cargo->getCargoConfianza())
			return true;
		if($update_cargo['cargo_jefe'] !== $cargo->getCargoJefe())
			return true;
		return false;
	}
}
 ?>