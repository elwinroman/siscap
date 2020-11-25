<?php 

require 'AjaxController.php';

// $data = json_decode($_REQUEST['data']);
$data = $_REQUEST['peticion'];

switch($data) {
	case 'getOficinasJefe':
		AjaxController::getOficinasJefe();
	break;
}

 ?>