<div id="crear-oficina">
	<div class="content-header">
		<h1>Crear oficina</h1>
		<ul>
			<li>Siscap</li>
			<li>Oficinas</li>
			<li>Crear oficina</li>
		</ul>
	</div>
	<div class="box">
		<form id="form-oficina" class="needs-validation" novalidate autocomplete="off" action="?controller=Oficina&action=crear" method="POST">
			<div class="box-title">Datos de la oficina</div>
			<div class="field">		<!-- Field NOMBRE -->
				<label for="nombre">Nombre</label>
				<input class="form-control form-control-sm" type="text" name="nombre" maxlength="100" pattern="\s*([A-Za-zÀ-ÿ]\s?)+\s*" required autofocus>
			</div>

			<div class="form-check field">
				<input type="checkbox" class="form-check-input" name="check" value="active">
				<label for="check" class="except">Habilitar oficina jefe</label>
			</div>

			<div class="field">		<!-- Field OFICINA-JEFE -->
				<label for="oficina-jefe">Oficina jefe</label><br>
				<select class="mySelectr" name="oficina-jefe"></select>
			</div>

			<div class="btn-group btn-group-sm">
				<button type="submit" class="btn btn-primary">Guardar</button>
				<button type="button" class="btn btn-secondary btn-limpiar">Limpiar</button>
			</div>
		</form>
	</div>
</div>
<?php if(isset($_SESSION['oficina']['crear'])): ?>
	<div id="alerta-crear-oficina" class="alerta-msg">
		<?=$_SESSION['oficina']['crear'];?>		
	</div>
<?php endif; ?>