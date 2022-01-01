<nav class="sidebar">
	<div class="menu-header">
		<div class="logo">
			<span>SISCAP</span>
		</div>

		<div class="menu-title">NAVIGATION</div>		
	</div>

	<div class="menu-content">
		<!-- Menu para el módulo Principal -->
		<div class="menu-box">
			<a class="menu-item" href="#" data-menu-item-id="1">
				<i class="i1 zmdi zmdi-apps"></i>
				<span>Dashboard</span>
				<i class="i-arrow zmdi zmdi-chevron-right"></i>
			</a>
			<ul class="submenu-box">
				<li>
					<a class="submenu-item" href="?controller=Test&action=test" data-submenu-item-id="1">Test</a>
				</li>
				<li>
					<a class="submenu-item" href="#">Option 2</a>
				</li>
			</ul>
		</div>

		<!-- Menu para el módulo Trabajador -->
		<div class="menu-box">
			<a class="menu-item" data-menu-item-id="2" href="#">
				<i class="i1 zmdi zmdi-accounts-outline"></i>
				<span>Trabajadores</span>
				<i class="i-arrow zmdi zmdi-chevron-right"></i>
			</a>
			<ul class="submenu-box">
				<li>
					<a class="submenu-item" data-submenu-item-id="1" 
					href="?controller=Trabajador&action=listar">Lista de trabajadores</a>
				</li>
				<li>
					<a class="submenu-item" data-submenu-item-id="2" 
					href="?controller=Trabajador&action=mostrarFormulario">Crear trabajador</a>
				</li>
			</ul>
		</div>

		<!-- Menu para el módulo Cargo -->
		<div class="menu-box">
			<a class="menu-item" href="#cargo" data-menu-item-id="3">
				<i class="i1 zmdi zmdi-tab"></i>
				<span>Cargos</span>
				<i class="i-arrow zmdi zmdi-chevron-right"></i>
			</a>
			<ul class="submenu-box">
				<li>
					<a class="submenu-item" data-submenu-item-id="1" 
					href="?controller=Cargo&action=listar">Lista de cargos</a>
				</li>
				<li>
					<a class="submenu-item" data-submenu-item-id="2" 
					href="?controller=Cargo&action=mostrarFormulario">Crear cargo</a>
				</li>
			</ul>
		</div>

		<!-- Menu para el módulo Oficina -->
		<div class="menu-box">
			<a class="menu-item" href="#" data-menu-item-id="4">
				<i class="i1 zmdi zmdi-triangle-up"></i>
				<span>Oficinas</span>
				<i class="i-arrow zmdi zmdi-chevron-right"></i>
			</a>
			<ul class="submenu-box">
				<li>
					<a class="submenu-item" data-submenu-item-id="1" 
					href="?controller=Oficina&action=listar">Lista de oficinas</a>
				</li>
				<li>
					<a class="submenu-item" data-submenu-item-id="2" 
					href="?controller=Oficina&action=mostrarFormulario">Crear oficina</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<!-- Aquí comienza la parte del contenido -->
<div class="content-page" spellcheck="false">	
<!-- spellcheck[false]: corrección de ortografía desactivada-->
	<div class="content">
