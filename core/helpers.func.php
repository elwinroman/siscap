<?php 

/**
 * Resetea una cadena reemplazando espacios en blanco en uno solo, convierte a minúsculas
 * @param{String} $cad
 * @return[String] $newCad
 */
function limpiarCadena($cad) {
    $cad = preg_replace('/\s+/', ' ', $cad);
    $newCad = trim(mb_strtolower($cad));
    return $newCad;
}
/**
 * Convierte a mayúsculas el primer caracter de cada palabra de una cadena, adaptada a UTF-8
 * Similar a la funcion PHP [ucwords]
 * @param{String} $cad
 * @return{String} $newCad
 */
function mb_ucwords($cad) {
	$newCad = mb_convert_case($cad, MB_CASE_TITLE, "UTF-8"); 
    return $newCad;
}
/**
 * Convierte a mayúsculas el primer caracter de cada palabra de una cadena
 * exceptuando conectores básicos (y, de, etc.)
 * @param{String} $word
 * @param{String} $newWord
 */
function my_mb_ucwords($cad) {
	$newCad = '';
	$cad = mb_ucwords($cad);
	$words = explode(' ', $cad);

	foreach ($words as $word)
		$newCad .= (mb_strlen($word) < 3) ? mb_strtolower($word) . ' ' : $word . ' '; 
	
	return trim($newCad);
}
 ?>