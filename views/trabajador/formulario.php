<div id="crear-trabajador">
	<div class="content-header">
		<h1>Crear trabajador</h1>
		<ul>
			<li>Siscap</li>
			<li>Trabajadores</li>
			<li>Crear trabajador</li>
		</ul>
	</div>
	<div class="box">
		<form id="form-trabajador" action="?controller=Trabajador&action=crear" class="needs-validation" method="POST" novalidate autocomplete="off">
			<div class="row g-0">
				<div class="col-md-6 main-column">
					<div class="box-title">Datos personales</div>
					<div class="field">		<!-- Field NOMBRES -->
						<label for="nombre">Nombres</label>
						<input class="form-control form-control-sm" type="text" name="nombre" maxlength="40" pattern="([\s]*[A-Za-zÀ-ÿ]+[\s]*)+" required autofocus>
						<div class="valid-feedback">Looks good!</div>
						<div class="invalid-feedback">Something is wrong.</div>
					</div>
					<div class="field">		<!-- Field APELLIDOS -->
						<label for="apellido">Apellidos</label>
						<input class="form-control form-control-sm" type="text" name="apellido" maxlength="40" pattern="([\s]*[A-Za-zÀ-ÿ]+[\s]*)+" required>
					</div>		
					<div class="row"> 
						<div class="col field multiple-input number">		<!-- Field DNI -->
							<label for="dni">DNI</label>
							<input class="form-control form-control-sm" type="text" name="dni" maxlength="18" pattern="[\s]*[0-9]{8}[\s]*" required>
						</div>
						<div class="col field multiple-input">		<!-- Field BIRTHDAY -->
							<label for="birthday">Fecha de nacimiento</label>
							<input class="form-control form-control-sm" name="birthday" type="date" required>
						</div>
					</div>

					<div class="row field">	<!-- Fields Lugar de nacimiento (Región, Provincia, Distrito) -->
						<label for="">Lugar de nacimiento</label>	<!-- Field REGION -->
						<div class="col-6 col-md-4 field2 multiple-input">
							<label for="region" class="except">Región</label><br>
							<select class="mySelectr lugar-residencia" name="region" required>
								<option value="puno">Puno</option>
			  				</select>
						</div>
						<div class="col-6 col-md-4 field2 multiple-input">	<!-- Field PROVINCIA -->
							<label for="provincia" class="except">Provincia</label><br>
							<select class="mySelectr lugar-residencia" name="provincia" required>
								
			  				</select>
						</div>
						<div class="col-6 col-md-4 multiple-input">	<!-- Field DISTRITO -->
							<label for="distrito" class="except">Distrito</label><br>
							<select class="mySelectr lugar-residencia" name="distrito" required>
			  				</select>
						</div>
					</div>
					<div class="row">
						<div class="field col-8">	<!-- Field DIRECCION -->
							<label for="domicilio">Domicilio</label>
							<input class="form-control form-control-sm" type="text" name="domicilio" maxlength="40" pattern="[\s]*[A-Za-zÀ-ÿ]+[.]{1}([\s]+[A-Za-zÀ-ÿ]+[\s]*)+" required>
						</div>
						<div class="field col">
							<label for="nro-domicilio" class="invisible">----</label>
							<input class="form-control form-control-sm" type="text" placeholder="Nro" name="nro-domicilio" pattern="[\s]*([0-9]+|(sn|SN){1})[\s]*" maxlength="10" required>
						</div>
					</div>

					<div class="field">	 <!-- Field GENERO -->
						<label class="d-block" for="genero">Genero</label>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="genero" value="m" required>
							<label class="form-check-label gender except" for="male">Masculino</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="genero" value="f" required>
							<label for="female" class="form-check-label gender except">Femenino</label>
						</div>
					</div>

					<div class="box-title">Datos de contacto</div>
					<div class="field">	<!-- Field EMAIL -->
						<label for="email">Correo electrónico</label>
						<input class="form-control form-control-sm" type="email" name="email" maxlength="50" required>
					</div>
					<div id="telefono" class="field multiple-input number">	<!-- Field CELULAR -->
						<label for="celular">Número de celular</label>
						<input type="text" class="form-control form-control-sm" name="celular" pattern="[\s]*[0-9]{9}[\s]*" maxlength="19" required>
					</div>
				</div>
				<div class="col-md-6 main-column">
					<div class="box-title">Datos académicos</div>
					<div class="field">		<!-- Field PROFESION -->
						<label for="profesion">Profesión</label>
						<input class="form-control form-control-sm" type="text" name="profesion" maxlength="40" pattern="([\s]*[A-Za-zÀ-ÿ]+[\s]*)+" required autofocus>
						<div class="valid-feedback">Looks good!</div>
						<div class="invalid-feedback">Something is wrong.</div>
					</div>
					<div class="box-title">Datos financieros</div>
					<div class="field number">		<!-- Field RUC -->
						<label for="ruc">RUC</label>
						<input class="form-control form-control-sm" type="text" name="ruc" pattern="[\s]*[0-9]{11}[\s]*" maxlength="21" required>
					</div>
					<div class="row field">
						<label>Fondo de pensiones</label> 
						<div class="col field2 multiple-input">		<!-- Field TIPO_SEGURO -->
							<label for="tipo-seguro" class="except">Tipo de seguro</label>
							<select class="mySelectr tipo-seguro" name="tipo-seguro" required></select>
						</div>
						<div class="col field2 multiple-input number">		<!-- Field CUSPP (Código único de seguro) -->
							<label for="cuspp-seguro" class="except">Código de afiliado</label>
							<input class="form-control form-control-sm" name="cuspp-seguro" type="text" pattern="[\s]*[A-Za-z0-9]{12}[\s]*" maxlength="22" required>
						</div>

						<div class="col multiple-input">	<!-- Field FECHA_REGISTRO_SEGURO (entrada) -->	
							<label for="fecha-registro-seguro" class="except">Fecha de afiliación</label>
							<input class="form-control form-control-sm" name="fecha-registro-seguro" type="date" required>
						</div>
					</div>
					<div class="field">		<!-- Field CCI_BN (Nro de Cuenta Bancaria) -->
						<label for="cci-bn">Nro Cuenta Bancaria (BANCO DE LA NACION)</label>
						<input class="form-control form-control-sm" type="text" name="cci-bn" pattern="[0-9]{20}" maxlength="20" required>
					</div>
					<div class="box-title">Asignar cargo</div>
					<div class="field">		<!-- Field CARGO -->
						<label for="cargo">Cargo</label><br>
						<select class="mySelectr asignar-cargo" name="cargo" required></select>
					</div>
					<div class="row"> 
						<div class="col field multiple-input">		<!-- Field FECHA_ENTRADA -->
							<label for="fecha-entrada">Fecha de entrada</label>
							<input class="form-control form-control-sm" type="date" name="fecha-entrada" required>
						</div>
						<div class="col field multiple-input">		<!-- Field FECHA_SALIDA -->
							<label for="fecha-salida">Fecha de salida</label>
							<input class="form-control form-control-sm" name="fecha-salida" type="date">
						</div>
						<div class="col field multiple-input">		<!-- Field CONDICION (tipo de contrato) -->
							<label for="condicion-contrato">Condición de contrato</label>
							<select class="mySelectr condicion-contrato" name="condicion-contrato" required></select>
						</div>
					</div>
				</div>
			</div>
			<div class="btn-group btn-group-sm">
				<button type="submit" class="btn btn-primary" id="save-button">Guardar</button>
				<button type="button" class="btn btn-secondary">Limpiar</button>
			</div>
		</form>
	</div>
</div>

<?php if(isset($_SESSION['trabajador']['crear'])): ?>
	<div id="alerta-crear-trabajador" class="alerta-msg">
		<?=$_SESSION['trabajador']['crear'];?>
	</div>
<?php endif; ?>

<?php if(isset($_SESSION['contrato']['asignar'])): ?>
	<div id="alerta-error-fechas" class="alerta-msg">
	</div>
<?php endif; ?>