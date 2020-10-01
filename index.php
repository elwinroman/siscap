<?php 
require 'autoload.php';

/* Comprueba si el controlador existe y es válido. */
if(isset($_GET['controller'])) {
	$name_controller = $_GET['controller'].'Controller';

	// Comprueba si existe la clase-controllador.
	if(class_exists($name_controller)) {
		$ClassController = new $name_controller;

		// Comprueba si existe el método en la clase y sea válido.
		if(isset($_GET['action']) && method_exists($name_controller, $_GET['action'])) {
			$action = $_GET['action'];
			$ClassController::$action();
		} else
			PAGE_NOT_FOUND('No es válido el método-acción o no existe');

	} else
		PAGE_NOT_FOUND('No existe controlador');

} else
	PAGE_NOT_FOUND('No es valido el nombre controlador');

/* Mensaje de página no encontrada */
function PAGE_NOT_FOUND($msg='') {
	echo 'La página que buscas no existe'.'<br>';
	echo $msg;
	exit();	
}
 ?>