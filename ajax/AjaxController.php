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
		$resultado = $consulta->listarOficinas();
		
		$htmlIconOpen = "<i class='icon-datatable-link zmdi zmdi-link' data-id='";
		$htmlIconClose = "'></i>";
		$nro = 1;		// Columna NRO (contador incrementable)

		if($resultado) {
			if(mysqli_num_rows($resultado) > 0) {
				while($dato = mysqli_fetch_assoc($resultado) ) {
					$data[] = $dato;
				}
				// Ordena oficinas y suboficinas tipo árbol
				for($i=0; $i<count($data); $i++) {
					if($data[$i]['oficina_id'] === NULL) {
						$nombre = my_mb_ucwords($data[$i]['nombre']); 	// Columna OFICINA
						$id = $data[$i]['id'];
						$link = $htmlIconOpen.$id.$htmlIconClose;

						$oficinas[] = array('#'=>$nro++, 'Oficina'=>$nombre, 'Ver'=>$link);
						
						// Añade sucesivamente suboficinas de la oficina jefe identificada
						for($j=0; $j<count($data); $j++) {
							if($data[$i]['id'] === $data[$j]['oficina_id'] ) {
								$nombre = my_mb_ucwords($data[$j]['nombre']); 	// Columna OFICINA
								$id = $data[$j]['id'];
								$link = $htmlIconOpen.$id.$htmlIconClose;

								$oficinas[] = array('#'=>$nro++, 'Oficina'=>$nombre, 'Ver'=>$link);
			 				}
						}
					}
				}
				echo json_encode($oficinas);
			} else {
				echo 'empty'; 
			};
		} else echo 'error';
	}
	/**
	 * Obtiene lista de suboficinas de una oficina-jefe
	 * @param {String} $id
	 */
	public function getSuboficinasEspecificas($idOficinaJefe) {
		$consulta = new AjaxModel();
		$resultado = $consulta->getSuboficinasEspecificas($idOficinaJefe);
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
		$resultado = $consulta->listarCargos($fecha_hoy);

		$htmlIconOpen = "<i class='icon-datatable-link zmdi zmdi-link' data-id='";
		$htmlIconClose = "'></i>";

		$htmlCardOpen = array(
			'sinPresupuesto' => "<div class='my-card text-white bg-danger text-center'>", 
			'vacante' => "<div class='my-card text-dark bg-warning text-center'>"
		);
		$htmlCardClose = "</div>";

		if($resultado) {
			if(mysqli_num_rows($resultado) > 0) {
				while($data = mysqli_fetch_assoc($resultado)) {
					$nombreCargo = my_mb_ucwords($data['cargo']);		// Columna CARGO
					$nombreOficina = my_mb_ucwords($data['oficina']);	// Columna OFICINA
					$nroPlaza = $data['nro_plaza'];						// Columna #
					$id = $data['id'];
					$link = $htmlIconOpen.$id.$htmlIconClose;
					
					// Para la Columna OCUPANTE
					$ocupante;
					if($data['estado_presupuesto'] == 1) {	// Si el cargo tiene Presupuesto para contratar
						if(!empty($data['trabajador_actual'])) {
							$datosSeparados = explode('-', $data['trabajador_actual']);
							$nombreTrabajador = my_mb_ucwords($datosSeparados[0]);
							$ocupante = $nombreTrabajador;
						} else {
							$ocupante = $htmlCardOpen['vacante'] . 'VACANTE' . $htmlCardClose;
						}
					} else {
						$ocupante = $htmlCardOpen['sinPresupuesto'] . 'SIN PRESUPUESTO' . $htmlCardClose;
					}

					$cargos[] = array('#'=>$nroPlaza, 'Cargo'=>$nombreCargo, 'Ocupante'=>$ocupante, 'Oficina'=>$nombreOficina, 'Ver'=>$link);
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
	public function setEstadoPresupuesto($id_cargo, $new_status) {
		$peticion = new AjaxModel();
		$resultado = $peticion->setEstadoPresupuesto($id_cargo, $new_status);
		echo $resultado;		
		if($resultado)
			echo 'petition successfully';
		else
			echo 'error sending petition';
	}
}
// $consulta = new AjaxController();
// $consulta->getCargosList();
// $nombre = mb_strtoupper($data[$i]['nombre']); 	// Columna OFICINA MAYUSCULA
 ?>