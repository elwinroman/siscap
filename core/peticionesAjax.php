<?php 

require '../ajax/AjaxController.php';

if(isset($_POST['peticion'])) {
	$data = $_POST['peticion'];

	switch($data) {
		case 'getOficinasJefe':
			AjaxController::getOficinasJefe();
		break;
		case 'getOficinasList':
			AjaxController::getOficinasList();
		break;
		case 'getSuboficinasEspecificas':
			if(isset($_POST['id'])) {
				$id = $_POST['id'];
				AjaxController::getSuboficinasEspecificas($id);
			}
		break;
		case 'getCargosList':
			AjaxController::getCargosList();
		break;
	}
}

 ?>