<div>MOSTRANDO OFICINA CREADA</div>

<?php if(isset($_SESSION['oficina']['crearOficina'])): ?>
	<div id="alerta-crear-oficina" style="display: none">
		<?=$_SESSION['oficina']['crearOficina'];?>		
	</div>
<?php endif; ?>