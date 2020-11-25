<h1>FORMULARIO PARA CREAR OFICINA</h1>
<form id="form-oficina" class="container-fluid needs-validation" novalidate autocomplete="off" action="?controller=Oficina&action=crearOficina" method="POST">
	<div class="col-sm box">
		<div class="field">		<!-- Field NOMBRE -->
			<label for="nombre">Nombre</label>
			<input class="form-control form-control-sm" type="text" name="nombre" maxlength="50" pattern="\s*([A-Za-zÀ-ÿ]\s?)+\s*" required autofocus>
			<div class="valid-feedback">Looks good!</div>
			<div class="invalid-feedback">Something is wrong.</div>
		</div>

		<div class="form-check field">
			<input type="checkbox" class="form-check-input" name="check" value="active">
			<label for="check">Si está creando una suboficina, active esta opción para habilitar la pertenencia a una oficina jefe </label>
		</div>

		<div class="field">		<!-- Field OFICINA-JEFE -->
			<label for="oficina">Oficina jefe</label><br>
			<select id="sct-oficina-jefe" class="mySelectr" name="oficina">
			</select>
		</div>
	</div>

	<div class="btn-group btn-group-sm">
		<button type="submit" class="btn btn-primary" id="save-button">
			<i class="zmdi zmdi-floppy"></i>
			<span>Guardar</span>
		</button>
		<button type="button" class="btn btn-danger">
			<i class="zmdi zmdi-close-circle"></i>
			<span>Cancelar</span>
		</button>
	</div>
</form>