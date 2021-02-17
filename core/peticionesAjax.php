<?php 

require '../ajax/AjaxController.php';

if(isset($_POST['peticion'])) {
	$data = $_POST['peticion'];

	$peticion = new AjaxController();
	switch($data) {
		case 'getOficinasJefe':
			$peticion->getOficinasJefe();
		break;
		case 'listarOficinas':
			$peticion->listarOficinas();
		break;
		case 'getSuboficinasEspecificas':
			if(isset($_POST['id'])) {
				$id = $_POST['id'];
				$peticion->getSuboficinasEspecificas($id);
			}
		break;
		case 'listarCargos':
			$peticion->listarCargos();
		break;
		case 'setEstadoPresupuesto':
			if(isset($_POST['id']) && isset($_POST['status'])) {
				$id_cargo = $_POST['id'];
				$new_status = $_POST['status'];
				$peticion->setEstadoPresupuesto($id_cargo, $new_status);
			}
		break;
	}
}

 ?>