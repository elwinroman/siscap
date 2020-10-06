document.addEventListener('DOMContentLoaded', function() {
	"use strict";
	
	const _SIZE = {
		smallDevice		: 576,	// SmallDevices
		extraSmallDev 	: 400	// ExtraSmallDevices
	};

	var menu = Menu();
	menu.clickMenuIcon();
	menu.clickMenuCloseIcon();
	menu.resizeEvent();

	function Menu() {

		var menuSidebar = document.getElementById("sidebar-menu");
		var menuIcon = document.querySelector(".mynavbar .zmdi-menu");
		var menuCloseIcon = document.querySelector("div.menu-title .zmdi-close");

		var estadoMenu = true;	// true (menu activo), false (menu oculto)

		/* Muestra el menu */
		function abrir() {
			menuSidebar.style.opacity = "1";
			if(window.innerWidth > _SIZE.extraSmallDev)
				menuSidebar.style.transform = "translate(0, 0)";
			else
				menuSidebar.style.transform = "translate(0, 0)";
		}
		/* Oculta el menu */
		function cerrar() {
			if(window.innerWidth > _SIZE.extraSmallDev)
				menuSidebar.style.transform = "translate(-100%, 0)";
			else
				menuSidebar.style.transform = "translate(0, -100%)";
		}
		/* Evento resize en la ventana */
		function resizeEvent() {
			window.addEventListener('resize', function() {
				reposicionarMenu();
			}, false);
		}
		/* Reposicionamiento del menu(sidebar) */
		function reposicionarMenu() {
			if(!estadoMenu && (window.innerWidth > _SIZE.extraSmallDev)) {
				menuSidebar.style.opacity = "0";
				menuSidebar.style.transform = "translate(-100%, 0)";
			}
			else if(!estadoMenu && (window.innerWidth <= _SIZE.extraSmallDev)) {
				menuSidebar.style.opacity = "0";
				menuSidebar.style.transform = "translate(0, -100%)";
			}
		}
		return {
			clickMenuIcon: function() {
				menuIcon.addEventListener('click', function() {
					abrir();
					estadoMenu = true;
				}, false);
			},
			clickMenuCloseIcon: function() {
				menuCloseIcon.addEventListener('click', function() {
					cerrar();
					estadoMenu = false;
				}, false);
			},
			resizeEvent: function() {
				resizeEvent();
			}
		}		
	}
});