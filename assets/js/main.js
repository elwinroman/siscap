document.addEventListener('DOMContentLoaded', function() {
	"use strict";
	
	const SizeDevice = {
		small		: 576,	// SmallDevices
		extraSmall 	: 400	// ExtraSmallDevices
	};

	var menu = Menu();
	menu.clickMenuOpenIcon();
	menu.clickMenuCloseIcon();
	menu.clickAnyPlace();
	menu.resizeEvent();
	menu.slideSubmenus();

	function Menu() {

		var menuSidebar = document.getElementById("sidebar-menu");
		var menuOpenIcon = document.querySelector(".mynavbar .zmdi-menu");
		var menuCloseIcon = document.querySelector("div.menu-title .zmdi-close");
		var menuItemList = document.getElementsByClassName("menu-item");
		var menuItemIconList = document.querySelectorAll(".menu-item > i.i2");
		var submenuPanelList = document.querySelectorAll(".menu-item + div.submenu-box");

		var estadoMenu = true;	// true (menu activo), false (menu oculto)

		/** Muestra el menu */
		function showMenu() {
			if(window.innerWidth > SizeDevice.extraSmall)
				menuSidebar.style.transform = "translate(0, 0)";
			else
				menuSidebar.style.transform = "translate(0, 0)";
			estadoMenu = true;
		}
		/** Oculta el menu */
		function hideMenu() {
			if(window.innerWidth > SizeDevice.extraSmall)
				menuSidebar.style.transform = "translate(-101%, 0)";
			else
				menuSidebar.style.transform = "translate(0, -101%)";
			estadoMenu = false;
		}
		/* Evento resize en la ventana */
		function resizeEvent() {
			window.addEventListener('resize', function() {
				reposicionarMenu();
			}, false);
		}
		/** Efecto SLIDE Submenus */
		function slideSubmenus() {
			for(var menuItem of menuItemList) {
				menuItem.addEventListener('click', function(event) {
					event.preventDefault();
					var submenuBox = this.nextElementSibling;
										
					// Cuando no esta activado
					if(this.classList.contains("active") === false) {
						ocultarSubmenus();
						Animation.slideDown(submenuBox, 200);
						myRemoveClass(menuItemList, "active");
						this.classList.add("active");
						// Icono chevron up-down
						myRemoveClass(menuItemIconList, "zmdi-chevron-up");
						myAddClass(menuItemIconList, "zmdi-chevron-down");
						this.querySelector("i.i2").classList.remove("zmdi-chevron-down");
						this.querySelector("i.i2").classList.add("zmdi-chevron-up");
					} else {	// Cuando está activo el menú (abiertos los submenus)
						this.classList.remove("active");
						Animation.slideUp(submenuBox, 200);
						// Icono chevron up-down
						this.querySelector("i.i2").classList.remove("zmdi-chevron-up");
						this.querySelector("i.i2").classList.add("zmdi-chevron-down");
					}
				}, false);
			}
		}
		/** Ocultar todos los submenus */
		function ocultarSubmenus() {
			submenuPanelList.forEach(function(submenuPanel) {
				Animation.slideUp(submenuPanel, 200);
			});
		}
		/** 
		* Remueve nombres de clases a una lista de elementos 
		* @param{HTMLCollection} elementList 	=> Lista de nodos
		* @param{string} nameClass 			=> Nombre de clase
		*/
		function myRemoveClass(elementList, nameClass) {
			for(var element of elementList)
				element.classList.remove(nameClass);
		}
		/** 
		* Añade nombres de clases a una lista de elementos 
		* @param {HTMLCollection} elementList => Lista de nodos
		* @param {string} nameClass			=> Nombre de clase
		*/
		function myAddClass(elementList, nameClass) {
			for(var element of elementList)
				element.classList.add(nameClass);
		}

		/** Reposicionamiento del menu(sidebar) */
		function reposicionarMenu() {
			if(!estadoMenu && (window.innerWidth > SizeDevice.extraSmall))
				menuSidebar.style.transform = "translate(-101%, 0)";
			else
				menuSidebar.style.transform = "translate(0, -101%)";
		}
		return {
			clickMenuOpenIcon: function() {
				menuOpenIcon.addEventListener('click', function() {
					showMenu();
				}, false);
			},
			clickMenuCloseIcon: function() {
				menuCloseIcon.addEventListener('click', function() {
					hideMenu();
				}, false);
			},
			/** Cierra el menu al hacer click en cualquier parte del contenido */
			clickAnyPlace: function() {
				var seccionContenido = document.querySelector("section.contenido");
				var myNavbar = document.querySelector("header > h3");
				seccionContenido.addEventListener('click', function() { 
					hideMenu(); 
				});
				myNavbar.addEventListener('click', function() { 
					hideMenu();
				});
			},
			resizeEvent: function() {
				resizeEvent();
			}, 
			slideSubmenus: function() {
				slideSubmenus();
			}
		}		
	}
	/////////////////////////////////////////////////////////////////////
	var Animation = {
		/**
	     * Efecto SlideUp
	     * @param {HTMLElement} element 	=> Nodo o elemento HTML
	     * @param {Number} duration 		=> Duración del efecto en milisegundos
	     */
		slideUp: function(element, duration = 400) {
			if(document.body.contains(element)) {
				element.style.height = 0;
				element.style.transitionDuration = duration + "ms";
				var submenuList = element.querySelectorAll("a.submenu-item");
				for(var submenu of submenuList) {
					submenu.style.transitionDuration = duration + "ms";
					submenu.style.opacity = 0;
					submenu.style.visibility = "hidden";
				}
			}
		},
	    /**
	     * Efecto SlideDown
	     * @param {HTMLElement} elemento 	=> Nodo o elemento HTML
	     * @param {Number} duration 		=> Duración del efecto en milisegundos
	     */
		slideDown: function(element, duration = 400) {
			if(document.body.contains(element)) {
				element.style.height = 80 + "px";
				element.style.transitionDuration = duration + "ms";
				var submenuList = element.querySelectorAll("a.submenu-item");
				for(var submenu of submenuList) {
					submenu.style.transitionDuration = duration + "ms";
					submenu.style.opacity = 1;
					submenu.style.visibility = "visible";
				}
			}
		}
	}
});