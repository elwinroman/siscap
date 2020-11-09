<h1>FORMULARIO PARA CREAR OFICINA</h1>
<form id="form-oficina" action="" class="container needs-validation" novalidate autocomplete="off">
	<div class="col box">
		<div class="field">		<!-- Field NOMBRE -->
			<label for="nombre">Nombre</label>
			<input class="form-control form-control-sm" type="text" name="nombre" maxlength="50" pattern="\s*([A-Za-zÀ-ÿ]\s?)+\s*" required autofocus>
			<div class="valid-feedback">Looks good!</div>
			<div class="invalid-feedback">Something is wrong.</div>
		</div>

		<div class="field">
			<label for="oficina">Oficina</label><br>
			<select id="oficina-jefe" class="mySelectr" name="oficina">
				<option value=""></option>
				<option value="1">Subgerencia 1</option>
				<option value="2">Subgerencia 2</option>
				<option value="2">Subgerencia 3</option>
				<option value="2">Subgerencia 4</option>
			</select>
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