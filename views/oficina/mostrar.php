<h1><?=$oficina->getNombre();?></h1>
<div class="container-md">
	<div class="row">
		<div class="col-md box">
			<h5 class="box-title">
				<i class="zmdi zmdi-archive"></i>
				<span><?=$tipo_oficina;?></span>
			</h5>
			<ul class="box-list">
			<?php if($is_oficina_jefe): ?>
				<?php if(is_array($suboficinas)): ?>
					<?php foreach($suboficinas as $value): ?>
						<li><a href="<?=$url.$value['id']; ?>"><?=$value['nombre']; ?></a></li>
					<?php endforeach; ?>
				<?php else: ?>
					<p><?=$suboficinas?></p>
				<?php endif; ?>
			<?php else: ?>
				<li><a href="<?=$url.$oficinaJefe['id']; ?>"><?=$oficinaJefe['nombre']; ?></a></li>
			<?php endif; ?>
			</ul>
		</div>

		<div class="col-md box">
			<h5 class="box-title">
				<i class="zmdi zmdi-assignment"></i>
				<span>Cargos</span>
			</h5>
			<ul class="box-list btn-group-vertical">
				<?php if(is_array($cargos)): ?>
					<?php foreach($cargos as $value): ?>
						<li><?=$value['nombre']; ?>
							<span class="badge bg-dark"><?=$value['cont']; ?></span>
						</li>
					<?php endforeach; ?>
				<?php else: ?>
					<p><?=$cargos; ?></p>
				<?php endif; ?>
			</ul>
		</div>
	</div>

	<div class="btn-group btn-group-sm">
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-oficina">
			<i class="zmdi zmdi-edit"></i>
			<span>Editar</span>
		</button>
		<button type="button" class="btn btn-danger" id="button-eliminar-oficina" value="<?=$oficina->getId();?>">
			<i class="zmdi zmdi-delete"></i>
			<span>Eliminar</span>
		</button>
	</div>

	<!-- MODAL EDITAR -->
	<div class="modal fade" id="modal-editar-oficina">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Editar OFICINA</h5>
		        	<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="form-oficina" class="container-fluid needs-validation" novalidate autocomplete="off" action="?controller=Oficina&action=editar&id=<?=$oficina->getId();?>" method="POST">
						<div class="field">		<!-- Field NOMBRE -->
							<label for="nombre">Nombre</label>
							<input class="form-control form-control-sm" type="text" name="nombre" maxlength="50" pattern="\s*([A-Za-zÀ-ÿ]\s?)+\s*" required autofocus
							value="<?=my_mb_ucwords($oficina->getNombre());?>">
							<div class="valid-feedback">Looks good!</div>
							<div class="invalid-feedback">Something is wrong.</div>
						</div>

						<div class="form-check field">
							<?php if($is_oficina_jefe): ?>
								<input type="checkbox" class="form-check-input" name="check" value="active">
							<?php else: ?>
								<input type="checkbox" class="form-check-input" name="check" value="active" checked>
							<?php endif; ?>	
							<label for="check">Si está creando una suboficina, active esta opción para habilitar la pertenencia a una oficina jefe </label>
						</div>

						<div class="field">		<!-- Field OFICINA-JEFE -->
							<label for="oficina-jefe">Oficina jefe</label><br>
							<select class="mySelectr" name="oficina-jefe" data-oficina-jefe="<?=$oficinaJefe['id'];?>">
								<!-- Selectr -->
							</select>
						</div>
						<button type="submit" class="btn btn-secondary float-right">
							<i class="zmdi zmdi-floppy"></i>
							<span>Actualizar</span>
						</button>	
					</form>	
				</div>
				<!-- <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        	<button type="button" class="btn btn-primary">Save changes</button>
				</div> -->
			</div>
		</div>
	</div>
</div>
<?php if(isset($_SESSION['oficina']['crear'])): ?>
	<div id="alerta-crear-oficina" class="alerta-msg">
		<?=$_SESSION['oficina']['crear'];?>
	</div>
<?php endif; ?>
<?php if(isset($_SESSION['oficina']['editar'])): ?>
	<div id="alerta-editar-oficina" class="alerta-msg">
		<?=$_SESSION['oficina']['editar'];?>
	</div>
<?php endif; ?>
