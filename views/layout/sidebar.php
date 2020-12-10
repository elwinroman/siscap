<header class="mynavbar">
	<i class="btn-menu zmdi zmdi-menu zmdi-hc-lg"></i>
	<h3 class="nv-title">Sistema cap</h3>
</header>

<nav id="sidebar-menu" class="dark-style active">
	<div class="menu-title">
		<span>TITULO MENU</span>
		<i class="zmdi zmdi-close"></i>
	</div>

	<div class="user-info ui">
		<figure>
			<img src="assets/img/avatar-male.png" alt="UserIcon">
			<figcaption class="text-center">User Name</figcaption>
		</figure>
		<div class="menu-setting-options">
			<i class="zmdi zmdi-settings"></i>			
			<i class="zmdi zmdi-power" data-toggle="tooltip" title="Salir del sistema"></i>
		</div>
	</div>
	
	<div class="full-menu">
		<!-- Menu para el módulo Principal -->
		<div class="menu-box">
			<a class="menu-item" href="#principal" data-menu-item-id="1">
				<i class="i1 zmdi zmdi-view-dashboard"></i>
				<span>Principal</span>
			</a>
		</div>

		<!-- Menu para el módulo Trabajador -->
		<div class="menu-box">
			<a class="menu-item" data-menu-item-id="2" href="#trabajador">
				<i class="i1 zmdi zmdi-accounts"></i>
				<span>Trabajadores</span>
				<i class="i2 zmdi zmdi-chevron-down"></i>
			</a>
			<div class="submenu-box">
				<a class="submenu-item" data-submenu-item-id="1" href="#">
					<i class="zmdi zmdi-circle"></i>
					<span>Inicio</span>
				</a>
				<a class="submenu-item" data-submenu-item-id="2" href="?controller=Trabajador&action=formularioTrabajador">
					<i class="zmdi zmdi-circle"></i>
					<span>Crear trabajador</span>
				</a>
			</div>
		</div>

		<!-- Menu para el módulo Cargo -->
		<div class="menu-box">
			<a class="menu-item" href="#cargo" data-menu-item-id="3">
				<i class="i1 zmdi zmdi-case"></i>
				<span>Cargos</span>
				<i class="i2 zmdi zmdi-chevron-down"></i>
			</a>
			<div class="submenu-box">
				<a class="submenu-item" data-submenu-item-id="1" href="?controller=Cargo&action=listar">
					<i class="zmdi zmdi-circle"></i>
					<span>Inicio</span>
				</a>
				<a class="submenu-item" data-submenu-item-id="2" href="?controller=Cargo&action=mostrarFormulario">
					<i class="zmdi zmdi-circle"></i>
					<span>Crear cargo</span>
				</a>
			</div>
		</div>

		<!-- Menu para el módulo Oficina -->
		<div class="menu-box">
			<a class="menu-item" href="#oficina" data-menu-item-id="4">
				<i class="i1 zmdi zmdi-balance"></i>
				<span>Oficinas</span>
				<i class="i2 zmdi zmdi-chevron-down"></i>
			</a>
			<div class="submenu-box">
				<a class="submenu-item" data-submenu-item-id="1" href="?controller=Oficina&action=listar">
					<i class="zmdi zmdi-circle"></i>
					<span>Inicio</span>
				</a>
				<a class="submenu-item" data-submenu-item-id="2" href="?controller=Oficina&action=mostrarFormulario">
					<i class="zmdi zmdi-circle"></i>
					<span>Crear oficina</span>
				</a>
			</div>
		</div>
	</div>
</nav>

<!-- Aquí comienza la parte del contenido -->
<section class="contenido" spellcheck="false">	<!-- spellcheck[false]: corrección de ortografía desactivada-->