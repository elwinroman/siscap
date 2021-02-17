<h1>LISTA DE CARGOS</h1>
<div class="container-md" id="lista-cargo">
	<table id="dt-cargo">
		<!-- Datatable -->
	</table>

	<div class="card rounded-0">
		<h5 class="card-header">Visibilidad de columnas</h5>
		<div id="checkbox-container" class="card-body text-center">
			<!-- Checkboxes columns -->
		</div>
	</div>
</div>

<?php if(isset($_SESSION['cargo']['eliminar'])): ?>
	<div id="alerta-eliminar-cargo" class="alerta-msg">
		<?=$_SESSION['cargo']['eliminar'];?>		
	</div>
<?php endif; ?>