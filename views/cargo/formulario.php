<div id="crear-cargo">
	<div class="content-header">
		<h1>Crear cargo</h1>
		<ul>
			<li>Siscap</li>
			<li>Cargos</li>
			<li>Crear cargo</li>
		</ul>
	</div>
	<div class="box">
		<form id="form-cargo" class="needs-validation" novalidate autocomplete="off" action="?controller=Cargo&action=crear" method="POST">
			<div class="row g-0">
				<div class="col-md-6 main-column">
					<div class="box-title">Información del cargo</div>
					<div class="field">		<!-- Field NOMBRE -->
						<label for="nombre">Nombres</label>
						<input class="form-control form-control-sm" type="text" name="nombre" maxlength="50" pattern="\s*([A-Za-zÀ-ÿ]\s?)+\s*" required autofocus>
					</div>
					
					<div class="row align-items-end"> 
						<div class="col field">		<!-- Field NRO-PLAZA -->
							<label for="nr-plaza">Nro de plaza</label>
							<input class="form-control form-control-sm" type="text" name="nro-plaza" maxlength="3" pattern="[0-9]{3}" placeholder="e.g 'xxx'" required>
						</div>
						<!--  
						<div class="col field">-->		<!-- Field REGIMEN-LABORAL -->
							<!-- <label for="regimen-laboral">Régimen Laboral</label><br>
							<select class="mySelectr regimen-select" name="regimen-laboral">
								<option value="1">728</option>
								<option value="2">276</option>
			  				</select>
						</div> -->
					</div>
					<div class="row align-items-end">
						<div class="col field">	 <!-- Field CARGO DE CONFIANZA -->
							<label class="d-block" for="cargo-confianza">¿Cargo de confianza?</label>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="cargo-confianza" value="1" required>
								<label class="form-check-label except">Si</label>
							</div>	
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="cargo-confianza" value="0" required>
								<label class="form-check-label except">No</label>
							</div>
						</div>
						<div class="col field">	 <!-- Field CARGO JEFE -->
							<label class="d-block" for="cargo-jefe">¿Cargo jefe?</label>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="cargo-jefe" value="1" required>
								<label class="form-check-label except">Si</label>
							</div>	
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="cargo-jefe" value="0" required>
								<label class="form-check-label except">No</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 main-column">
					<div class="box-title">Asignar oficina</div>

					<div class="field">		<!-- Field OFICINA -->
						<label for="oficina">Oficina</label><br>
						<select class="mySelectr" name="oficina-jefe" data-modulo=" Crear" required></select> 
					</div>
					
					<div class="form-check">
						<input type="checkbox" class="form-check-input" name="check" value="active">
						<label for="check" class="except">Habilitar Suboficinas</label>
					</div>
					
					<div class="field">		<!-- Field SUBOFICINA -->
						<label for="suboficina">Suboficina</label><br>
						<select class="mySelectr" name="suboficina"></select>
					</div>
				</div>
			</div>

			<div class="btn-group btn-group-sm">
				<button type="submit" class="btn btn-primary" id="save-button">Guardar</button>
				<button type="button" class="btn btn-secondary btn-limpiar">Limpiar</button>
			</div>
		</form>
	</div>
</div>

<?php if(isset($_SESSION['cargo']['crear'])): ?>
	<div id="alerta-crear-cargo" class="alerta-msg">
		<?=$_SESSION['cargo']['crear'];?>
	</div>
<?php endif; ?>