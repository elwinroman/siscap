<?php 
class ControladorBase {
	public function __construct() {
		require 'helpers.func.php';

		// Incluir todos los modelos
		foreach (glob("models/*.php") as $file)
			require_once $file;
	}
	/**
	 * Redirecciona a una URL soluciondo el error tipico de "cannot modify header information"
	 * @param {String} $url
	 */
	protected function redirect($url) {
		if (!headers_sent()) {    
		    header('Location: '.$url);
			exit;
		} else {  
	        echo '<script type="text/javascript">';
	        echo 'window.location.href="'.$url.'";';
	        echo '</script>';
	        echo '<noscript>';
	        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
	        echo '</noscript>'; 
	        exit;
	    }
	}
}
 ?>