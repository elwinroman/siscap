<h1>FORMULARIO PARA CREAR CARGO</h1>
<form id="form-cargo" action="" class="container-fluid needs-validation" novalidate autocomplete="off">
	<div class="row">
		<div class="col-sm box">
			<div class="titulo">Información del cargo</div>
			<div class="field">		<!-- Field NOMBRE -->
				<label for="nombre">Nombres</label>
				<input class="form-control form-control-sm" type="text" name="nombre" maxlength="50" pattern="\s*([A-Za-zÀ-ÿ]\s?)+\s*" required autofocus>
				<div class="valid-feedback">Looks good!</div>
				<div class="invalid-feedback">Something is wrong.</div>
			</div>
			
			<div class="row"> 
				<div class="col field">		<!-- Field NRO-PLAZA -->
					<label for="nr-plaza">Nro de plaza</label>
					<input class="form-control form-control-sm" type="text" name="nro-plaza" maxlength="3" pattern="\s*[0-9]{3}\s*" required>
				</div>
				<div class="col field">		<!-- Field REGIMEN-LABORAL -->
					<label for="regimen-laboral">Régimen Laboral</label><br>
					<select class="mySelectr regimen-select" name="regimen-laboral" required>
						<option value="1">728</option>
						<option value="2">276</option>
	  				</select>
				</div>
			</div>
			<div class="row">
			<div class="col field">	 <!-- Field CARGO DE CONFIANZA -->
				<label class="d-block" for="cargo-confianza">¿Cargo de confianza?</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="cargo-confianza" value="si" required>
					<label class="form-check-label">Si</label>
				</div>	
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="cargo-confianza" value="no" required>
					<label class="form-check-label">No</label>
				</div>
			</div>
			<div class="col field">	 <!-- Field CARGO JEFE -->
				<label class="d-block" for="cargo-jefe">¿Cargo jefe?</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="cargo-jefe" value="si" required>
					<label class="form-check-label">Si</label>
				</div>	
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="cargo-jefe" value="no" required>
					<label class="form-check-label">No</label>
				</div>
			</div>
			</div>
		</div>
		<div class="col-sm box">
			<div class="titulo">Asignar oficina</div>
			<div class="field">		<!-- Field OFICINA -->
				<label for="oficina">Oficina</label><br>
				<select class="mySelectr asignar-oficina" name="oficina" required>
					<option value="1">Gerencia 1</option>
					<option value="2">Gerencia 2</option>
					<option value="2">Gerencia 3</option>
					<option value="2">Gerencia 4</option>
  				</select> 
			</div>
			<div class="field">		<!-- Field OFICINA -->
				<label for="suboficina">Suboficina</label><br>
				<select class="mySelectr asignar-oficina" name="suboficina" required>
					<option value="1">Subgerencia 1</option>
					<option value="2">Subgerencia 2</option>
					<option value="2">Subgerencia 3</option>
					<option value="2">Subgerencia 4</option>
  				</select>
			</div>
		</div>
	</div>

	<div class="btn-group btn-group-sm">
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