<?php 

class Trabajador extends ModelBase {
	private $id, $nombre, $apellido, $dni, $fecha_nacimiento, $lugar_residencia, $domicilio;
	private $genero, $email, $celular, $profesion, $ruc, $tipo_seguro, $cuspp_seguro;
	private $fecha_registro_seguro, $cci_bn;
	private $table; // nombre de tabla 

	public function __construct() {
		parent::__construct();
		$this->table = 'trabajadores';
	}

	//////////////// Querys DB ////////////////

	// Inserta un nuevo trabajador (SQL INSERT INTO)
	public function insertar() {
		$query = "INSERT INTO trabajadores (id, nombre, apellido, dni, fecha_nacimiento,
						lugar_residencia, domicilio, genero, email, celular, profesion, 
						ruc, cci_bn, tipo_seguro, cussp_seguro, fecha_registro_seguro)
				VALUES (? , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$data = [null, $this->nombre, $this->apellido, $this->dni, $this->fecha_nacimiento,
				$this->lugar_residencia, $this->domicilio, $this->genero, $this->email, 
				$this->celular, $this->profesion, $this->ruc, $this->cci_bn, $this->tipo_seguro,
				$this->tipo_seguro, $this->cussp_seguro, $this->fecha_registro_seguro];
		$res = $this->preparedQuery($query, $data);
		$this->id = $this->getOnlyId('trabajadores', 'dni', $this->dni);
		return $res;
	}

	//////////////// Setters & Getters ////////////////
	public function setId($id) {
		$this->id = $id;
	}
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	public function setApellido($apellido) {
		$this->apellido = $apellido;
	}
	public function setDni($dni) {
		$this->dni = $dni;
	}
	public function setFechaNacimiento($fecha_nacimiento) {
		$this->fecha_nacimiento = $fecha_nacimiento;
	}
	public function setLugarResidencia($lugar_residencia) {
		$this->lugar_nacimiento = $lugar_nacimiento;
	}
	public function setDomicilio($domicilio) {
		$this->domicilio = $domicilio;
	}
	public function setGenero($genero) {
		$this->genero = $genero;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	public function setCelular($celular) {
		$this->celular = $celular;
	}
	public function setProfesion($profesion) {
		$this->profesion = $profesion;
	}
	public function setRuc($ruc) {
		$this->ruc = $ruc;
	}
	public function setTipoSeguro($tipo_seguro) {
		$this->tipo_seguro = $tipo_seguro;
	}
	public function setCusppSeguro($cuspp_seguro) {
		$this->cuspp_seguro = $cuspp_seguro;
	}
	public function setFechaAfiliacionSeguro($fecha_afiliacion_seguro) {
		$this->fecha_afiliacion_seguro = $fecha_afiliacion_seguro;
	}
	public function setCciBn($cci_bn) {
		$this->cci_bn = $cci_bn;
	}
	public function getId() {
		return $this->id;
	}
	public function getNombre() {
		return $this->nombre;
	}
	public function getApellido() {
		return $this->apellido;
	}
	public function getDni() {
		return $this->dni;
	}
	public function getFechaNacimiento() {
		return $this->fecha_nacimiento;
	}
	public function getLugarResidencia() {
		return $this->lugar_residencia;
	}
	public function getDomicilio() {
		return $this->domicilio;
	}
	public function getGenero() {
		return $this->genero;
	}
	public function getEmail() {
		return $this->email;
	}
	public function getCelular() {
		return $this->celular;
	}
	public function getProfesion() {
		return $this->profesion;
	}
	public function getRuc() {
		return $this->ruc;
	}
	public function getTipoSeguro() {
		return $this->tipo_seguro;
	}
	public function getCusppSeguro() {
		return $this->cuspp_seguro;
	}
	public function getFechaAfiliacionSeguro() {
		return $this->fecha_afiliacion_seguro;
	}
	public function getCciBn() {
		return $this->cci_bn;
	}
	public function getTable() {
		return $this->table;
	}

}

 ?>