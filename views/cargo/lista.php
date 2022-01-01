<div id="lista-cargo">
	<div class="content-header">
		<h1>Lista de cargos</h1>
		<ul>
			<li>Siscap</li>
			<li>Oficinas</li>
			<li>Lista de cargos</li>
		</ul>
	</div>
	<div class="box">
		<div class="box-title">Datatable cargo</div>
		<div class="exportable-options btn-group btn-group-sm">
			<button class="btn btn-danger pdf-button">
				<i class="zmdi zmdi-file"></i>
				<span>PDF</span>
			</button>
			<button class="btn btn-success excel-button">
				<i class="zmdi zmdi-file-text"></i>
				<span>Excel</span>
			</button>
			<button class="btn btn-warning print-button">
				<i class="zmdi zmdi-print"></i>
				<span>Print</span>
			</button>
		</div>
		<table id="dt-cargo"><!-- Datatable --></table>
	</div>

	<div class="box">
		<div class="box-title">Visibilidad de columnas</div>
		<div id="checkbox-datatable-container" class="text-center">
			<!-- Checkboxes columns -->
		</div>
	</div>
</div>

<?php if(isset($_SESSION['cargo']['eliminar'])): ?>
	<div id="alerta-eliminar-cargo" class="alerta-msg">
		<?=$_SESSION['cargo']['eliminar'];?>		
	</div>
<?php endif; ?>