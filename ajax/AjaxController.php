<?php 
require_once 'AjaxModel.php';
require_once '../core/helpers.func.php';

class AjaxController {

	// Obtiene lista de oficinas-jefe 
	public function getOficinasJefe() {

		$consulta = new AjaxModel();
		$resultado = $consulta->getOficinasJefe();

		if($resultado) {
			while($row = $resultado->fetch_assoc()) {
				$id = $row['id'];
				$nombre = my_mb_ucwords($row['nombre']);
				$oficinasJefe[] = ["value" => $id, "name" => $nombre]; 
			}
			echo json_encode($oficinasJefe);
		} else echo 'error';
	}

	// Obtiene lista de las Oficinas para el datatable-oficina
	public function listarOficinas() {
		$consulta = new AjaxModel();
		$res = $consulta->listarOficinas();
		
		$icon_open = "<i class='dt-link zmdi zmdi-plus-circle' data-id='";
		$icon_close = "'></i>";
		$nro = 1;		// Columna NRO (contador incrementable)

		if($res) {
			if(mysqli_num_rows($res) > 0) {
				while($dato = mysqli_fetch_assoc($res)) {
					$link = $icon_open.$dato['id'].$icon_close;

					$oficinas[] = array(
						'#' 	  => $nro++,
						'Oficina' => my_mb_ucwords($dato['nombre']),
						'Ver'	  => $link
					);
				}
				echo json_encode($oficinas);
			} else echo 'empty';
		} else echo 'error';
	}
	/**
	 * Obtiene lista de suboficinas de una oficina-jefe
	 * @param {String} $id
	 */
	public function getSuboficinas($idOficinaJefe) {
		$consulta = new AjaxModel();
		$resultado = $consulta->getSuboficinas($idOficinaJefe);
		$suboficinas = [];
		
		if($resultado) {
			while($row = $resultado->fetch_assoc()) {
				$id = $row['id'];
				$nombre = my_mb_ucwords($row['nombre']);
				$suboficinas[] = array("value" => $id, "name" => $nombre); 
			}
			echo json_encode($suboficinas);
		} else echo 'error';
	}
	// Obtiene lista de los Cargos para el datatable-cargo
	public function listarCargos() {
		$fecha_hoy = date("Y-m-d");
		$consulta = new AjaxModel();
		$res = $consulta->listarCargos($fecha_hoy);

		$icon_open = "<i class='dt-link zmdi zmdi-plus-circle' data-id='";
		$icon_close = "'></i>";
		$card_open = array(
			'sin_presupuesto' => "<div class='my-card text-white bg-danger text-center'>", 
			'vacante'		 => "<div class='my-card text-dark bg-warning text-center'>"
		);
		$card_close = "</div>";
		$cont = 1;

		if($res) {
			if(mysqli_num_rows($res) > 0) {
				while($data = mysqli_fetch_assoc($res)) {
					$id = $data['id'];
					$trabajador_actual = "";
					
					if($data['estado_presupuesto'] == 1) {
						if(!empty($data['trabajador_actual']))
							$trabajador_actual = my_mb_ucwords($data['trabajador_actual']);
						else
							$trabajador_actual = $card_open['vacante'].'VACANTE'.$card_close;
					} else
						$trabajador_actual = $card_open['sin_presupuesto'].'SIN PRESUPUESTO'.$card_close;
					
					$cargos[] = array(
						'#'		=> $cont++, 
						'Cargo'	=> my_mb_ucwords($data['cargo']),
						'Plaza'	=> $data['nro_plaza'],
						'Trabajador' => $trabajador_actual,
						'Oficina'	 => my_mb_ucwords($data['oficina']),
						'CC'	=> $data['cargo_confianza'],
						'CJ' 	=> $data['cargo_jefe'],
						'Ver'	=> $icon_open.$id.$icon_close
					);
				}
				echo json_encode($cargos);
			} else echo 'empty';
		} else echo 'error';
	}
	/**
	 * Cambia el estado de presupuesto de un cargo
	 * @param {String} $id_cargo	[Number]
	 * @param {String} $new_status  [Number]
	 */
	public function cambiarEstadoPresupuesto($id_cargo, $new_status) {
		$peticion = new AjaxModel();
		$resultado = $peticion->cambiarEstadoPresupuesto($id_cargo, $new_status);		
		if(!$resultado)
			echo 'error';
	}
	// Obtiene cargos vacantes
	public function getCargosVacantes() {
		$peticion = new AjaxModel();
		$resultado = $peticion->getCargosVacantes();
		if($resultado) {
			while($data = $resultado->fetch_assoc()) {
				$cargo_vacante = array(
					'id'		=> $data['id'],
					'nombre'	=> my_mb_ucwords($data['nombre']),
					'nro_plaza' => $data['nro_plaza']
				);
				$cargos_vacantes[] = $cargo_vacante;
			}
			echo json_encode($cargos_vacantes);
		} else
		echo 'error';
	}
}
// $consulta = new AjaxController();
// $consulta->getCargosVacantes();
// $nombre = mb_strtoupper($data[$i]['nombre']); 	// Columna OFICINA MAYUSCULA
 ?>