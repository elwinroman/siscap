<?php 

/**
 * Resetea una cadena reemplazando espacios en blanco en uno solo
 * @param{String} $str
 * @return[String] $newStr
 */
function limpiarCadena($str) {
    $cad = preg_replace('/\s+/', ' ', $str);
    $newStr = trim(mb_strtolower($cad));
    return $newStr;
}
 ?>