<?php
class TrabajadorController extends ControladorBase {
	private $url_listar  = '';
	private $url_mostrar = '?controller=Trabajador&action=mostrar&id=';
	private $url_formulario = '?controller=Trabajador&action=mostrarFormulario';

	public function __construct() {
		parent::__construct();
	}

	public function mostrarFormulario() {
		require 'views/trabajador/formulario.php';

		// Liberar cookies
		if(isset($_SESSION['trabajador']['crear']))
			unset($_SESSION['trabajador']['crear']);
		if(isset($_SESSION['contrato']['asignar']))
			unset($_SESSION['contrato']['asignar']);
	}
	public function listar() {
		require_once 'views/trabajador/lista.php';
	}

	public function crear() {
		echo "hola hijo de puta";
		if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['dni']) && isset($_POST['birthday']) && isset($_POST['nombre']) && isset($_POST['region']) && isset($_POST['provincia']) && isset($_POST['distrito']) && isset($_POST['domicilio']) && isset($_POST['nro-domicilio']) && isset($_POST['genero']) && isset($_POST['email']) && isset($_POST['celular']) && isset($_POST['profesion']) && isset($_POST['ruc']) && isset($_POST['tipo-seguro']) && isset($_POST['cuspp-seguro']) && isset($_POST['fecha-registro-seguro']) && isset($_POST['cci-bn']) && isset($_POST['cargo']) && isset($_POST['fecha-entrada']) && isset($_POST['fecha-salida']) && isset($_POST['condicion-contrato'])) {
			$datos_trabajador = array(
				'nombre'		=> limpiarCadena($_POST['nombre']),
				'apellido'		=> limpiarCadena($_POST['apellido']),
				'dni'			=> $_POST['dni'],
				'fecha_nacimiento' => $_POST['birthday'],
				'lugar_residencia' => limpiarCadena($_POST['region']).'-'.limpiarCadena($_POST['provincia'].'-'.limpiarCadena($_POST['distrito'])),		
				'domicilio' 	=> limpiarCadena($_POST['domicilio']).'-'.limpiarCadena($_POST['nro-domicilio']),
				'genero'		=> $_POST['genero'],
				'email'			=> limpiarCadena($_POST['email']),
				'celular'		=> $_POST['celular'],
				'profesion' 	=> limpiarCadena($_POST['profesion']),
				'ruc'			=> $_POST['ruc'],
				'tipo_seguro' 	=> limpiarCadena($_POST['tipo-seguro']),
				'cuspp_seguro'	=> mb_strtoupper($_POST['cuspp-seguro']),
				'fecha_registro_seguro' => $_POST['fecha-registro-seguro'],
				'cci-bn'		=> $_POST['cci-bn']
			);
			
			if(!empty($_POST['fecha-salida']))
				$fecha_salida = $_POST['fecha-salida'];
			else
				$fecha_salida = 'null';

			$datos_contrato = array(
				'trabajador_id'	=> null,
				'cargo_id'		=> $_POST['cargo'],
				'fecha_entrada'	=> $_POST['fecha-entrada'],
				'fecha_salida'	=> $fecha_salida,
				'condicion'		=> limpiarCadena($_POST['condicion-contrato'])
			);
			
			/*///// testing data /////////*/
			echo 'DATOS DE TRABAJADOR'.'<br>';
			foreach ($datos_trabajador as $key => $value)
				echo $key.' -> '.$value.'<br>';
			echo '<hr>'.'DATOS DE CONTRATO'.'<br>';
			foreach ($datos_contrato as $key => $value)
				echo $key.' -> '.$value.'<br>';

			if(!$this->validarFechasContrato($datos_contrato))
				$date = "... invalido ...";
			else
				$date = "... valido ...";
			echo 'FECHA DE CONTRATO: '.$date;
			die();
			/*///// testing data /////////*/

			// Comprobar si las fechas de entrada y salida del contrato son válidas
			if(!$this->validarFechasContrato($datos_contrato)) {
				// Error en las fechas de contrato
				$_SESSION['contrato']['asignar'] = 'the-content-doesnt-matter';
				$this->redirect($this->url_formulario);
			}

			// Crear un nuevo trabajador en la base de datos
			$objTrabajador = new Trabajador();
			$this->setearDatosTrabajador($objTrabajador, $data_trabajador);
			
			$res1 = $objTrabajador->insertar();
			if($res1) {
				// Crear el contrato con los datos del trabajador creado y el cargo seleccionado
				$objContrato = new Contrato();
				$id_t = $objTrabajador->getId();
				$datos_contrato['trabajador_id'] = $id_t;
				$this->setearDatosContrato($objContrato, $data_contrato);

				$res2 = $objContrato->insertar();
				if($res2) {
					$_SESSION['trabajador']['crear'] = 'success';
					$this->redirect($this->url_mostrar.$id_t);
				} else {
					// $objTrabajador->delete($id_t);	//eliminar ultimo trabajador creado
					$_SESSION['trabajador']['crear'] = 'error';
					$this->redirect($this->url_formulario);
				}
			} else {
				$_SESSION['trabajador']['crear'] = 'error';
				$this->redirect($this->url_formulario);
			}
		}
	}
	/**
	 * Valida fechas de contrato (solo para cargos vacantes)
	 * @param{Array} $datos_contrato
	 * @return{Bool}
	 */
	private function validarFechasContrato($datos_contrato) {
		$INVALIDO = false;
		$VALIDO = true;
		$fecha_entrada = new DateTime($datos_contrato['fecha_entrada']);
		$fecha_salida = $datos_contrato['fecha_salida'];
		$cargo_id = $datos_contrato['cargo_id'];

		$objContrato = new Contrato();
		$res = $objContrato->obtenerHistorialCargo($cargo_id);
		
		// La fecha de salida no debe estar vacia
		if($fecha_salida !== 'null') {
			$fecha_salida = new DateTime($fecha_salida);
			// La fecha de entrada debe ser menor a la fecha salida.
			if($fecha_entrada > $fecha_salida)
				return $INVALIDO;
			
			// La fecha de entrada no debe estar en el rango de las fechas ocupadas
			while($data = mysqli_fetch_assoc($res)) { 
				if($fecha_entrada >= $data['fecha_entrada'] && $fecha_entrada <= $data['fecha_salida'])
					return $INVALIDO;
			}

			// La fecha de salida debe ser menor a la fecha de entrada más proximo de las fechas ocupadas
	 		while($data = mysqli_fetch_assoc($res)) {
				if($fecha_entrada < $data['fecha_entrada']) {
					if($fecha_salida >= $data['fecha_entrada'])
						return $INVALIDO;
				}
			}
		///////////////////////////////////////////////////////////
		} else {
			// La fecha de entrada debe ser mayor a la fecha de salida de las fechas ocupadas
			while($data = mysqli_fetch_assoc($res)) {
				if($fecha_entrada <= $data['fecha_salida'])
					return $INVALIDO;
			}
		}
		return $VALIDO;
	}

	private function setearDatosTrabajador($trabajador, $data_trabajador) {
		$trabajador->setNombre($data_trabajador['nombre']);
		$trabajador->setApellido($data_trabajador['apellido']);
		$trabajador->setDni($data_trabajador['dni']);
		$trabajador->setFechaNacimiento($data_trabajador['fecha_nacimiento']);
		$trabajador->setLugarResidencia($data_trabajador['lugar_residencia']);
		$trabajador->setDomicilio($data_trabajador['domicilio']);	
		$trabajador->setGenero($data_trabajador['genero']);
		$trabajador->setEmail($data_trabajador['email']);
		$trabajador->setCelular($data_trabajador['celular']);
		$trabajador->setProfesion($data_trabajador['profesion']);
		$trabajador->setRuc($data_trabajador['ruc']);
		$trabajador->setTipoSeguro($data_trabajador['tipo_seguro']);
		$trabajador->setCusppSeguro($data_trabajador['cuspp_seguro']);
		$trabajador->setFechaAfiliacionSeguro($data_trabajador['fecha_afiliacion_seguro']);
		$trabajador->setCciBn($data_trabajador['cci_bn']);
	}
	private function setearDatosContrato($contrato, $datos_contrato) {
		$contrato->setTrabajadorId($datos_contrato['trabajador_id']);
		$contrato->setCargoId($datos_contrato['cargo_id']);
		$contrato->setFechaInicio($datos_contrato['fecha_inicio']);
		$contrato->setFechaFin($datos_contrato['fecha_fin']);
		$contrato->setCondicion($datos_contrato['condicion']);
	}
}


 ?>