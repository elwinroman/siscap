<h1>FORMULARIO PARA CREAR TRABAJADOR</h1>
<form id="form-trabajador" action="" class="container-fluid needs-validation" novalidate autocomplete="off">
	<!-- //////////// DATOS PERSONALES ////////////////// -->
	<div class="row">
		<div class="col-sm box">
			<div class="titulo">Datos personales</div>
			<div class="field">		<!-- Field NOMBRES -->
				<label for="nombre">Nombres</label>
				<input class="form-control form-control-sm" type="text" name="nombre" maxlength="30" pattern="\s*([A-Za-zÀ-ÿ]\s?)+\s*" required autofocus>
				<div class="valid-feedback">Looks good!</div>
				<div class="invalid-feedback">Something is wrong.</div>
			</div>
			<div class="field">		<!-- Field APELLIDOS -->
				<label for="apellido">Apellidos</label>
				<input class="form-control form-control-sm" type="text" name="apellido" maxlength="30" pattern="\s*([A-Za-zÀ-ÿ]\s*)+\s*" required>
			</div>

			<div class="row"> 
				<div class="col field multiple-input">		<!-- Field DNI -->
					<label for="dni">DNI</label>
					<input class="form-control form-control-sm" type="text" name="dni" maxlength="8" pattern="\s*[0-9]{8}\s*"  required>
				</div>
				<div class="col field multiple-input">		<!-- Field BIRTHDAY -->
					<label for="birthday">Fecha de nacimiento</label>
					<input class="form-control form-control-sm" name="birthday" type="date" required>
				</div>
			</div>

			<div class="row">	<!-- Fields Lugar de nacimiento (Región, Provincia, Distrito) -->
				<label for="">Lugar de nacimiento</label>	<!-- Field REGION -->
				<div class="col-6 col-md-4 field multiple-input">
					<label for="region">Región</label><br>
					<select class="mySelectr lugar-nacimiento" name="region" required>
						<option value="puno">Puno</option>
	  				</select>
				</div>
				<div class="col-6 col-md-4 field multiple-input">	<!-- Field PROVINCIA -->
					<label for="provincia">Provincia</label><br>
					<select id="myselecttt" class="mySelectr lugar-nacimiento" name="provincia" required>
						
	  				</select>
				</div>
				<div class="col-6 col-md-4 field multiple-input">	<!-- Field DISTRITO -->
					<label for="distrito">Distrito</label><br>
					<select class="mySelectr lugar-nacimiento" name="distrito" required>
	  				</select>
				</div>
			</div>

			<div class="field">	<!-- Field ADDRESS -->
				<label for="direccion">Direccion</label>
				<input class="form-control form-control-sm" type="text" name="direccion" required>
			</div>

			<div class="field">	 <!-- Field GENDER -->
				<label class="d-block" for="genero">Genero</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="genero" value="male" required>
					<label class="form-check-label gender" for="male">Male</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="genero" value="female" required>
					<label for="female" class="form-check-label gender">Female</label>
				</div>
			</div>

			<div class="titulo">Datos de contacto</div>

			<div class="field">	<!-- Field EMAIL -->
				<label for="email">Correo electrónico</label>
				<input class="form-control form-control-sm" type="email" name="email" required>
			</div>
			<div id="telefono" class="field">	<!-- Field TELEFONO -->
				<label for="telefono">Teléfono o celular</label>
				<input type="text" class="form-control form-control-sm" name="telefono" pattern="\s*[0-9]\s*" maxlenght="9">
			</div>
		</div>

		<div class="col-sm box">
			<div class="titulo">Datos académicos</div>
			<div class="field">		<!-- Campo (profesion) -->
				<label for="profesion">Profesión</label>
				<input class="form-control form-control-sm" type="text" name="profesion" maxlength="40" pattern="\s*([A-Za-zÀ-ÿ]\s?)+\s*" required autofocus>
				<div class="valid-feedback">Looks good!</div>
				<div class="invalid-feedback">Something is wrong.</div>
			</div>
			<div class="titulo">Datos financieros</div>
			<div class="field">		<!-- Campo (RUC) -->
				<label for="ruc">RUC</label>
				<input class="form-control form-control-sm" type="text" name="ruc" pattern="\s*[0-9]{8}\s*" maxlenght="20" required>
			</div>
			
			<div class="row"> 
				<div class="col field multiple-input">		<!-- Campo (Tipo de seguro) -->
					<label for="tipo-seguro">Tipo de seguro</label>
					<input class="form-control form-control-sm" type="text" name="tipo-seguro" pattern="\s*[0-9]{8}\s*" maxlenght="20" required>
				</div>
				<div class="col field multiple-input">		<!-- Campo (Nro de seguro) -->
					<label for="nro-seguro">Nro de seguro</label>
					<input class="form-control form-control-sm" name="nro-seguro" type="text" required>
				</div>
				<div class="col field multiple-input">		<!-- Campo (Fecha de afiliación al seguro) -->
					<label for="afiliacion-seguro">Fecha de afiliación</label>
					<input class="form-control form-control-sm" name="afiliacion-seguro" type="date" required>
				</div>
				<div class="field">		<!-- Campo (Nro de Cuenta Bancario BN) -->
					<label for="nro-banco">Nro Cuenta Bancaria (BANCO DE LA NACION)</label>
					<input class="form-control form-control-sm" type="text" name="nro-banco" pattern="\s*[0-9]{8}\s*" maxlenght="20" required>
				</div>
			</div>
			<div class="titulo">Asignar cargo</div>
			<div class="field">		<!-- Campo (Cargo) -->
				<label for="cargo">Cargo</label><br>
				<select class="mySelectr asignar-cargo" name="cargo" required>
					<!-- <option value="2" selected>Gerente de sistemas</option> -->
  				</select>
			</div>
			<div class="row"> 
				<div class="col field multiple-input">		<!-- Campo (Inicio de contrato) -->
					<label for="inicio">Inicio de contrato</label>
					<input class="form-control form-control-sm" type="date" name="inicio" required>
				</div>
				<div class="col field multiple-input">		<!-- Campo (fin de contrato) -->
					<label for="fin">Fin de contrato</label>
					<input class="form-control form-control-sm" name="fin" type="date">
				</div>
			</div>
		</div>
	</div>

	<div class="btn-group">
		<button type="submit" class="btn btn-primary" id="save-button">
			<i class="zmdi zmdi-floppy"></i>
			<span>Guardar</span>
		</button>
		<button type="button" class="btn btn-danger">
			<i class="zmdi zmdi-floppy"></i>
			<span>Cancelar</span>
		</button>
	</div>
</form>