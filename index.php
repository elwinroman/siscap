<?php
session_start();
require_once 'core/ControladorBase.php';
require_once 'core/ModelBase.php';
require_once 'autoload.php';
require_once 'views/layout/header.php';
require_once 'views/layout/navbar.php';
require_once 'views/layout/sidebar.php';

/* Comprueba si el controlador existe y es válido. */
if(isset($_GET['controller'])) {
	$name_controller = $_GET['controller'].'Controller';

	// Comprueba si existe la clase-controllador.
	if(class_exists($name_controller)) {
		$ClassController = new $name_controller;

		// Comprueba si existe el método en la clase y sea válido.
		if(isset($_GET['action']) && method_exists($name_controller, $_GET['action'])) {
			$action = $_GET['action'];
			$ClassController->$action();
		}
	}
} else {
	// $url = "core/error404.php";
	// echo '<script type="text/javascript">';
 //    echo 'window.location.href="'.$url.'";';
 //    echo '</script>';
 //    echo '<noscript>';
 //    echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
 //    echo '</noscript>'; 
 //    exit;
}
require_once 'views/layout/footer.php';

 ?>