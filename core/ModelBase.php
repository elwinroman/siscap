<?php 
class ModelBase {
	private $db;			// Object Database
	private $conn;			// Conexión a la base de datos
	private $num_affected_rows;

	protected function __construct() {
		require_once 'config/bd.php';
		$this->db = new Database();
	}
	/**
	 * Sentencia query preparada
	 * @param{String} query
	 * @param{Array} args
	 * @return{mysqli_result} res
	 */
	protected function preparedQuery($query, array $args) {
		$this->conn = $this->db->connect();
		$stmt   = $this->conn->prepare($query);
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

        // para SELECT devuelve un conjunto de resultados
        // para otras consultas DML devuelve FALSE
        if($stmt->execute()) {
        	$res = $stmt->get_result();
        	if(!$res) $res = true;
        } else $res = false;

        $this->num_affected_rows = mysqli_affected_rows($this->conn);
        $stmt->close();
        return $res;
	}
	/**
	 * Sentencia query normal
	 * @param{String} query
	 * @return{mysqli_result} res
	 */
	protected function query($query) {
		$this->conn = $this->db->connect();
		$res = $this->conn->query($query);
		$this->num_affected_rows = mysqli_affected_rows($this->conn);
		$this->conn->close();
		return $res;
	}
	/**
	 * Selecciona datos de una tabla mediante id
	 * @param{Int} id
	 * @param{mysqli_result} res
	 */
	public function getById($id, $table) {
		$query = "SELECT * FROM $table WHERE id=?";
		$res = $this->preparedQuery($query, [$id]);
		return $res;
	}
	/**
	 * Obtiene solo el id de un registro mediante un campo UNIQUE
	 * @param{String} tabla
	 * @param{String} campo
	 * @param{String} valor 	//-..-
	 * @return{String} id
	 */
	protected function getOnlyId($tabla, $campo, $valor) {
		$query = "SELECT id FROM $tabla WHERE $campo = '$valor'";
		$res = $this->query($query);

		if($res && mysqli_num_rows($res) == 1) {
			while($id = mysqli_fetch_assoc($res))
				return $id['id'];
		}
	} 
}
 ?>