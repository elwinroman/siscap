<h1>FORMULARIO PARA CREAR CARGO</h1>
<form id="form-cargo" class="container-fluid needs-validation" novalidate autocomplete="off" action="?controller=Cargo&action=crear" method="POST">
	<div class="row">
		<div class="col-md box">
			<div class="titulo">Información del cargo</div>
			<div class="field">		<!-- Field NOMBRE -->
				<label for="nombre">Nombres</label>
				<input class="form-control form-control-sm" type="text" name="nombre" maxlength="50" pattern="\s*([A-Za-zÀ-ÿ]\s?)+\s*" required autofocus>
				<div class="valid-feedback">Looks good!</div>
				<div class="invalid-feedback">Something is wrong.</div>
			</div>
			
			<div class="row align-items-end"> 
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
			<div class="row align-items-end">
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
		<div class="col-md box">
			<div class="titulo">Asignar oficina</div>

			<div class="field">		<!-- Field OFICINA -->
				<label for="oficina">Oficina</label><br>
				<select class="mySelectr" name="oficina-jefe" required>
					<!-- Selectr -->
  				</select> 
			</div>
			
			<div class="form-check field">
				<input type="checkbox" class="form-check-input" name="check" value="active">
				<label for="check">Habilitar Suboficinas</label>
			</div>
			
			<div class="field">		<!-- Field SUBOFICINA -->
				<label for="suboficina">Suboficina</label><br>
				<select class="mySelectr" name="suboficina">
					<!-- Selectr -->
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