<?php 
require_once '../ajax/AjaxModel.php';

class AjaxController {

	/* Obtiene solo oficinas-jefe */
	public static function getOficinasJefe() {

		$consultaAjax = new AjaxModel();
		$resultado = $consultaAjax->getOficinasJefe();

		if($resultado) {
			while($row = $resultado->fetch_assoc()) {
				$id = $row['id'];
				$nombre = ucwords($row['nombre']);
				$data[] = ["value" => $id, "name" => $nombre]; 
			}
			echo json_encode($data);
		} else
			echo 'error';
	}
}

 ?>