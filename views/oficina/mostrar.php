<div id="mostrar-oficina">
	<div class="content-header">
		<h1><?=$show['oficina']['nombre'];?></h1>
		<ul>
			<li>Siscap</li>
			<li>Oficinas</li>
		</ul>
	</div>
	<div class="row g-0 box">
		<div class="col-md-6 main-column">
			<div class="box-title">
				<i class="zmdi zmdi-archive"></i>
				<span><?=$show['oficina']['header'];?></span>
			</div>
			<?php if(is_array($show['oficina']['lista'])): ?>
			<ul class="lista-suboficinas">
				<?php foreach($show['oficina']['lista'] as $value): ?>
				<li><a href="<?=$this->url['mostrar'].$value['id']; ?>"><?=$value['nombre'];?></a></li>
				<?php endforeach; ?>
			</ul>
			<?php else: ?>
				<p><?=$show['oficina']['lista']?></p>
			<?php endif; ?>
		</div>
		<div class="col-md-6 main-column">
			<div class="box-title">
				<i class="zmdi zmdi-assignment"></i>
				<span>Cargos</span>
			</div>
			<?php if(is_array($show['cargo']['lista'])): ?>
			<ul>
				<?php foreach($show['cargo']['lista'] as $value): ?>
				<li>
					<span><?=$value['nombre']; ?></span>
					<span class="badge bg-dark"><?=$value['cont']; ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php else: ?>
				<p><?=$show['cargo']['lista']; ?></p>
			<?php endif; ?>
		</div>
		<div class="btn-group btn-group-sm">
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-editar-oficina">
				<i class="zmdi zmdi-edit"></i>
				<span>Editar</span>
			</button>
			<button type="button" class="btn btn-danger btn-eliminar" value="<?=$show['oficina']['id'];?>">
				<i class="zmdi zmdi-delete"></i>
				<span>Eliminar</span>
			</button>
		</div>
	</div>


	<!-- MODAL EDITAR -->
	<div class="modal fade" id="modal-editar-oficina" data-bs-backdrop="static">
		<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Editar oficina</h5>
		        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="form-oficina" class="needs-validation" novalidate autocomplete="off" action="<?=$this->url['editar'].$show['oficina']['id'];?>" method="POST">
						<div class="field">		<!-- Field NOMBRE -->
							<label for="nombre">Nombre</label>
							<input class="form-control form-control-sm" type="text" name="nombre" maxlength="100" pattern="\s*([A-Za-zÀ-ÿ]\s?)+\s*" required autofocus
							value="<?=$show['oficina']['nombre'];?>">
							<div class="valid-feedback">Looks good!</div>
							<div class="invalid-feedback">Something is wrong.</div>
						</div>

						<div class="form-check">
							<?php if($es_oficina_jefe): ?>
								<input type="checkbox" class="form-check-input" name="check" value="active">
							<?php else: ?>
								<input type="checkbox" class="form-check-input" name="check" value="active" checked>
							<?php endif; ?>	
							<label for="check" class="except">Habilitar oficina jefe.</label>
						</div>

						<div class="field">		<!-- Field OFICINA-JEFE -->
							<label for="oficina-jefe">Oficina jefe</label><br>
							<select class="mySelectr" name="oficina-jefe" data-oficina-jefe=
								<?php if(!$es_oficina_jefe): ?>
									"<?=$show['oficina']['lista'][0]['id'];?>">
								<?php else: ?>
									"<?='null';?>">
								<?php endif; ?>
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
