<div id="mostrar-cargo">
	<div class="content-header">
		<h1>
			<?=$show['cargo']['nro_plaza'];?>
			<?=$show['cargo']['nombre'];?>
		</h1>
		<ul>
			<li>Siscap</li>
			<li>Oficinas</li>
		</ul>
	</div>
	<div class="box">
		<div class="row g-0">
			<div class="col-md-10">
				<div class="field">
					<div class="titulo">Trabajador actual</div>
					<div id="worker-cargo"><?=$show['cargo']['trabajador_actual'];?></div>
				</div>
				<div class="field">
					<div class="titulo">Oficina</div>
					<div><?=$show['cargo']['oficina'];?></div>
				</div>
				<div class="field cargo-status">
					<div class="titulo">Cargo Confianza</div>
					<span class="badge bg-success">
						<?php if($show['cargo']['confianza'] === 0):?>
							<?='NO';?>
						<?php else:?>
							<?='SI';?>
						<?php endif;?>
					</span>
				</div>
				<div class="field cargo-status">
					<div class="titulo">Cargo Jefe</div>
					<span class="badge bg-success">
						<?php if($show['cargo']['jefe'] === 0):?>
							<?='NO';?>
						<?php else:?>
							<?='SI';?>
						<?php endif;?>
					</span>
				</div>
			</div>
			<div class="col-md-2">
				<div class="field form-check form-switch status-presupuesto">
				<?php if($show['cargo']['presupuesto'] === 0): ?>
					<div class="form-check-label" for="switch1">Sin presupuesto</div>
					<input id="switch1" class="form-check-input" type="checkbox" data-id-cargo="<?=$show['cargo']['id'];?>">
				<?php else: ?>
					<div class="form-check-label" for="switch1">Con presupuesto</div>
					<input id="switch1" class="form-check-input" type="checkbox" data-id-cargo="<?=$show['cargo']['id'];?>" checked>
				<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="btn-group btn-group-sm">
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-editar-cargo">
			<i class="zmdi zmdi-edit"></i>
			<span>Editar</span>
		</button>
		<button type="button" class="btn btn-danger btn-eliminar" value="<?=$cargo->getId();?>">
			<i class="zmdi zmdi-delete"></i>
			<span>Eliminar</span>
		</button>
	</div>
	</div>

	<!-- ######################################## -->
	<!-- MODAL EDITAR -->
	<div class="modal fade" id="modal-editar-cargo" data-bs-backdrop="static">
		<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Editar cargo</h5>
		        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="form-cargo" class="needs-validation" novalidate autocomplete="off" action="?controller=Cargo&action=editar&id=<?=$show['cargo']['id'];?>" method="POST">
						<div class="field">		<!-- Field NOMBRE -->
							<label for="nombre">Nombres</label>
							<input class="form-control form-control-sm" type="text" name="nombre" maxlength="50" pattern="\s*([A-Za-zÀ-ÿ]\s?)+\s*" value="<?=$show['cargo']['nombre'];?>" required autofocus>
							<div class="valid-feedback">Looks good!</div>
							<div class="invalid-feedback">Something is wrong.</div>
						</div>
						
						<div class="col field">		<!-- Field NRO-PLAZA -->
							<label for="nr-plaza">Nro de plaza</label>
							<input class="form-control form-control-sm" type="text" name="nro-plaza" maxlength="3" pattern="\s*[0-9]{3}\s*" value="<?=$show['cargo']['nro_plaza'];?>" required>
						</div>

						<div class="row align-items-end">
							<div class="col field">	 <!-- Field CARGO DE CONFIANZA -->
								<label class="d-block" for="cargo-confianza">¿Cargo de confianza?</label>
								<div class="form-check form-check-inline">
									<?php if($show['cargo']['confianza'] === 1): ?>
										<input class="form-check-input" type="radio" name="cargo-confianza" value="1" checked required>
									<?php else: ?>
										<input class="form-check-input" type="radio" name="cargo-confianza" value="1" required>
									<?php endif; ?>
									<label class="form-check-label">Si</label>
								</div>	
								<div class="form-check form-check-inline">
									<?php if($show['cargo']['confianza'] === 0): ?>
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
									<?php if($show['cargo']['jefe'] === 1): ?>
										<input class="form-check-input" type="radio" name="cargo-jefe" value="1" checked required>
									<?php else: ?>
										<input class="form-check-input" type="radio" name="cargo-jefe" value="1" required>
									<?php endif; ?>
									<label class="form-check-label">Si</label>
								</div>	
								<div class="form-check form-check-inline">
									<?php if($show['cargo']['jefe'] === 0): ?>
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
							<select class="mySelectr" name="oficina-jefe" data-modulo="editar" data-oficina-id="<?=$show['oficina']['oficina_jefe'];?>" required>
								<!-- Selectr -->
			  				</select> 
						</div>
						
						<div class="form-check">
							<?php if($show['oficina']['suboficina'] === null): ?>
								<input type="checkbox" class="form-check-input" name="check" value="active">
							<?php else: ?>
								<input type="checkbox" class="form-check-input" name="check" value="active" checked>
							<?php endif; ?>
							<label for="check" class="except">Habilitar suboficinas</label>
						</div>
						
						<div class="field">		<!-- Field SUBOFICINA -->
							<label for="suboficina">Suboficina</label><br>
							<select class="mySelectr" name="suboficina" data-suboficina-id="<?=$show['oficina']['suboficina'];?>">
								<!-- Selectr -->
			  				</select>
						</div>
						<div class="mymodal-footer">
							<button type="submit" class="btn btn-secondary btn-sm float-right">
								<i class="zmdi zmdi-floppy"></i>
								<span>Actualizar</span>
							</button>	
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
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
