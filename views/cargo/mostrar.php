<h1><span> <?=$cargo->getNroPlaza();?> </span><?=$cargo->getNombre();?></h1>
<div class="container-full">
	<div class="box">
		<div class="field form-check form-switch status-presupuesto">
			<?php if($cargo->getEstadoPresupuesto() === 0): ?>
				<label class="form-check-label" for="switch1">Sin presupuesto</label><br>
				<input id="switch1" class="form-check-input" type="checkbox" data-id-cargo="<?=$cargo->getId();?>">
			<?php else: ?>
				<label class="form-check-label" for="switch1">Con presupuesto</label><br>
				<input id="switch1" class="form-check-input" type="checkbox" data-id-cargo="<?=$cargo->getId();?>" checked>
			<?php endif; ?>
		</div>
		<div class="field">
			<div class="titulo">Trabajador actual</div>
			<div>
				<i class="zmdi zmdi-account"></i>
				<span id="worker-cargo"><?=$trabajador;?></span>
			</div>
		</div>
		<div class="field">
			<div class="titulo">Oficina</div>
			<div>
				<i class="zmdi zmdi-archive"></i>
				<span><?=$oficinaName;?></span>
			</div>
		</div>
		<div class="field cargo-status">
			<div>Cargo Confianza</div>
			<span class="badge bg-success">
				<?php if($cargo->getCargoConfianza() === 0):?>
					<?='NO';?>
				<?php else:?>
					<?='SI';?>
				<?php endif;?>
			</span>
		</div>
		<div class="field cargo-status">
			<div>Cargo Jefe</div>
			<span class="badge bg-success">
				<?php if($cargo->getCargoJefe() === 0):?>
					<?='NO';?>
				<?php else:?>
					<?='SI';?>
				<?php endif;?>
			</span>
		</div>
	</div>

	<div class="btn-group btn-group-sm">
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-cargo">
			<i class="zmdi zmdi-edit"></i>
			<span>Editar</span>
		</button>
		<button type="button" class="btn btn-danger" id="button-eliminar-cargo" value="<?=$cargo->getId();?>">
			<i class="zmdi zmdi-delete"></i>
			<span>Eliminar</span>
		</button>
	</div>

	<!-- ######################################## -->
	<!-- MODAL EDITAR -->
	<div class="modal fade" id="modal-editar-cargo">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Editar CARGO</h5>
		        	<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="form-cargo" class="container-fluid needs-validation" novalidate autocomplete="off" action="?controller=Cargo&action=editar&id=<?=$cargo->getId();?>" method="POST">
						<div class="field">		<!-- Field NOMBRE -->
							<label for="nombre">Nombres</label>
							<input class="form-control form-control-sm" type="text" name="nombre" maxlength="50" pattern="\s*([A-Za-zÀ-ÿ]\s?)+\s*" value="<?=my_mb_ucwords($cargo->getNombre());?>" required autofocus>
							<div class="valid-feedback">Looks good!</div>
							<div class="invalid-feedback">Something is wrong.</div>
						</div>
						
						<div class="col field">		<!-- Field NRO-PLAZA -->
							<label for="nr-plaza">Nro de plaza</label>
							<input class="form-control form-control-sm" type="text" name="nro-plaza" maxlength="3" pattern="\s*[0-9]{3}\s*" value="<?=$cargo->getNroPlaza();?>" required>
						</div>

						<div class="row align-items-end">
							<div class="col field">	 <!-- Field CARGO DE CONFIANZA -->
								<label class="d-block" for="cargo-confianza">¿Cargo de confianza?</label>
								<div class="form-check form-check-inline">
									<?php if($cargo->getCargoConfianza() === 1): ?>
										<input class="form-check-input" type="radio" name="cargo-confianza" value="1" checked required>
									<?php else: ?>
										<input class="form-check-input" type="radio" name="cargo-confianza" value="1" required>
									<?php endif; ?>
									<label class="form-check-label">Si</label>
								</div>	
								<div class="form-check form-check-inline">
									<?php if($cargo->getCargoConfianza() === 0): ?>
										<input class="form-check-input" type="radio" name="cargo-confianza" value="0" checked required>
									<?php else: ?>
										<input class="form-check-input" type="radio" name="cargo-confianza" value="0" required>
									<?php endif; ?>
									<label class="form-check-label">No</label>
								</div>
							</div>
							<div class="col field">	 <!-- Field CARGO JEFE -->
								<label class="d-block" for="cargo-jefe">¿Cargo jefe?</label>
								<div class="form-check form-check-inline">
									<?php if($cargo->getCargoJefe() === 1): ?>
										<input class="form-check-input" type="radio" name="cargo-jefe" value="1" checked required>
									<?php else: ?>
										<input class="form-check-input" type="radio" name="cargo-jefe" value="1" required>
									<?php endif; ?>
									<label class="form-check-label">Si</label>
								</div>	
								<div class="form-check form-check-inline">
									<?php if($cargo->getCargoJefe() === 0): ?>
										<input class="form-check-input" type="radio" name="cargo-jefe" value="0" checked required>
									<?php else: ?>
										<input class="form-check-input" type="radio" name="cargo-jefe" value="0" required>
									<?php endif; ?>
									<label class="form-check-label">No</label>
								</div>
							</div>
						</div>

						<div class="field">		<!-- Field OFICINA -->
							<label for="oficina">Oficina</label><br>
							<select class="mySelectr" name="oficina-jefe" data-oficina-id="<?=$oficinas_data['oficina'];?>" required>
								<!-- Selectr -->
			  				</select> 
						</div>
						
						<div class="form-check field">
							<input type="checkbox" class="form-check-input" name="check" value="active">
							<label for="check">Habilitar Suboficinas</label>
						</div>
						
						<div class="field">		<!-- Field SUBOFICINA -->
							<label for="suboficina">Suboficina</label><br>
							<select class="mySelectr" name="suboficina" data-suboficina-id="<?=$oficinas_data['suboficina'];?>">
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
	<!-- ######################################### -->
</div>

<?php if(isset($_SESSION['cargo']['crear'])): ?>
	<div id="alerta-crear-cargo" class="alerta-msg">
		<?=$_SESSION['cargo']['crear'];?>
	</div>
<?php endif; ?>
<?php if(isset($_SESSION['cargo']['editar'])): ?>
	<div id="alerta-editar-cargo" class="alerta-msg">
		<?=$_SESSION['cargo']['editar'];?>
	</div>
<?php endif; ?>
