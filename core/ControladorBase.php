<?php 
class ControladorBase {
	public function __construct() {
		require 'helpers.func.php';

		// Incluir todos los modelos
		foreach (glob("models/*.php") as $file)
			require_once $file;
	}
	public function redirect() {
		/*redirect code here*/
	}
}
 ?>