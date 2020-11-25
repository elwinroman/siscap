<?php
/** 
 * Carga automáticamente todos los controladores que están el la carpeta CONTROLLERS.
 * @param[string] $classname: nombre del controlador
 */
function autoload($classname) {
	$file = 'controllers/' . $classname . '.php';
	if(file_exists($file)) 
		include $file;
}
spl_autoload_register('autoload');