<?php 

require '../ajax/AjaxController.php';

if(isset($_POST['peticion'])) {
	$data = $_POST['peticion'];

	$peticion = new AjaxController();
	switch($data) {
		case 'lista_oficinas_jefe':
			$peticion->getOficinasJefe();
			break;
		case 'lista_oficinas':
			$peticion->listarOficinas();
			break;
		case 'get_suboficinas':
			if(isset($_POST['id'])) {
				$id = $_POST['id'];
				$peticion->getSuboficinas($id);
			}
			break;
		case 'listar_cargos':
			$peticion->listarCargos();
			break;
		case 'cambiar_estado_presupuesto':
			if(isset($_POST['id']) && isset($_POST['status'])) {
				$id_cargo = $_POST['id'];
				$new_status = $_POST['status'];
				$peticion->cambiarEstadoPresupuesto($id_cargo, $new_status);
			}
			break;
		case 'obtener_cargos_vacantes':
			$peticion->getCargosVacantes();
			break;
	}
}

 ?>