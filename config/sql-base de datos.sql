
-- -----------------------------------------------------
-- Table 'oficinas'
-- -----------------------------------------------------
CREATE TABLE oficinas (
  id INT NOT NULL AUTO_INCREMENT,
  oficina_id INT NULL,
  nombre VARCHAR(100) NOT NULL,
  observacion VARCHAR(200) NULL,
  PRIMARY KEY (id),
  CONSTRAINT uq_nombre UNIQUE(nombre),
  CONSTRAINT fk_oficina FOREIGN KEY (oficina_id) REFERENCES oficinas (id) ON DELETE CASCADE ON UPDATE CASCADE
  ) ENGINE=INNODB;

-- -----------------------------------------------------
-- Table 'cargos'
-- -----------------------------------------------------
CREATE TABLE cargos (
  id INT NOT NULL AUTO_INCREMENT,
  oficina_id INT NOT NULL,
  nro_plaza CHAR(3) NOT NULL,
  nombre VARCHAR(50) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT uq_plaza UNIQUE(nro_plaza),
  CONSTRAINT fk_oficina2 FOREIGN KEY (oficina_id) REFERENCES oficinas (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;
ALTER TABLE cargos ADD cargo_confianza TINYINT(1) NOT NULL;
ALTER TABLE cargos ADD cargo_jefe TINYINT(1) NOT NULL;
ALTER TABLE cargos ADD estado_presupuesto TINYINT(1) NOT NULL DEFAULT 1;

-- -----------------------------------------------------
-- Table 'trabajadores'
-- -----------------------------------------------------
CREATE TABLE trabajadores (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(30) NOT NULL,
  apellido VARCHAR(30) NOT NULL,
  dni CHAR(8) NOT NULL,
  fecha_nacimiento DATE NOT NULL,
  lugar_residencia VARCHAR(90) NOT NULL,
  domicilio VARCHAR(40) NOT NULL,
  genero CHAR(1) NOT NULL,
  email VARCHAR(40) NOT NULL,
  celular CHAR(9) NOT NULL,
  profesion VARCHAR(30) NOT NULL,
  ruc CHAR(11) NOT NULL,
  cci_bn CHAR(20) NOT NULL,
  tipo_seguro VARCHAR(20) NOT NULL,
  cuspp_seguro CHAR(12) NOT NULL,
  fecha_afiliacion_seguro DATE NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT uq_dni UNIQUE(dni),
  CONSTRAINT uq_ruc UNIQUE(ruc),
  CONSTRAINT uq_cci_bn UNIQUE(cci_bn),
  CONSTRAINT uq_cuspp_seguro UNIQUE(cuspp_seguro)
) ENGINE=INNODB;

-- -----------------------------------------------------
-- Table 'contratos'
-- -----------------------------------------------------
CREATE TABLE contratos (
  id INT NOT NULL AUTO_INCREMENT,
  trabajador_id INT NOT NULL,
  cargo_id INT NOT NULL,
  fecha_entrada DATE NOT NULL,
  fecha_salida DATE NULL,
  condicion VARCHAR(12) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (trabajador_id) REFERENCES trabajadores (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (cargo_id) REFERENCES cargos (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;