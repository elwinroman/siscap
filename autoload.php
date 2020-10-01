<?php
/* Carga automáticamente todos los controladores que están el la carpeta CONTROLLERS.
* @param[string] $classname: nombre del controlador
*/
function autoload($classname) {
	if(file_exists('controllers/' . $classname . '.php')) 
		include 'controllers/' . $classname . '.php';
}
spl_autoload_register('autoload');