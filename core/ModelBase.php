<?php 
class ModelBase {
	private $database;	// Object DATABASE
	private $db;		// Base de datos conectada

	protected function __construct() {
		require 'config/bd.php';
		$this->database = new Database();
		$this->db = $this->database->conectar();
	}
	/**
	 * Consulta query segura
	 * @param{String} $sql => Consulta SQL preparada
	 * @param{Array} $data => Datos de consulta
	 * @param{String} $bind => 
	 */
	protected function queryPrepared($query, array $args) {
		$stmt   = $this->prepare($query);
        $params = [];
        $types  = array_reduce($args, function ($string, &$arg) use (&$params) {
            $params[] = &$arg;
            if (is_float($arg))         $string .= 'd';
            elseif (is_integer($arg))   $string .= 'i';
            elseif (is_string($arg))    $string .= 's';
            else                        $string .= 'b';
            return $string;
        }, '');
        array_unshift($params, $types);

        call_user_func_array([$stmt, 'bind_param'], $params);

        $result = $stmt->execute() ? $stmt->get_result() : false;

        $stmt->close();

        return $result;
	}
	/**
	 * Consulta query normal
	 * @param{String} $sql => Consulta SQL
	 * @return{Object mysqli_result} $query
	 */
	protected function query($sql) {
		$query = $this->db->query($sql);
		$this->db->close();
		return $query;
	} 
}

 ?>