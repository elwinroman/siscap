document.addEventListener('DOMContentLoaded', function() {
	"use strict";

	var menu = Menu();
	menu.clickMenuOpenIcon();
	menu.clickMenuCloseIcon();
	// menu.clickAnyPlace();
	menu.resizeEvent();
	menu.slideSubmenus();
	menu.restaurarItemsSeleccionados();

	function Menu() {

		var menuSidebar = document.getElementById("sidebar-menu");
		var menuOpenIcon = document.querySelector(".mynavbar .zmdi-menu");
		var menuCloseIcon = document.querySelector("div.menu-title .zmdi-close");
		var menuItemList = document.getElementsByClassName("menu-item");
		var menuItemIconList = document.querySelectorAll(".menu-item > i.i2");
		var submenuItemList = document.querySelectorAll(".submenu-item");
		var submenuPanelList = document.querySelectorAll(".menu-item + div.submenu-box");

		var estadoMenu = true;					// true (menu activo), false (menu oculto)
		
		// "key" y "value", cookies que permiten al menú no perder información al refrescar la página
		var keyMenuItem = "menuItemId"; 		// llave donde se almacena un valor del menú-item seleccionado
		var valueMenuItem = undefined;			// valor que se guarda en la llave
		var keySubmenuItem = "submenuItemId";
		var valueSubmenuItem = undefined;

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
		/** Despliega submenus, controla el efecto slide, etc... al hacer click en un item del menú */
		function clickMenuItem() {
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
						if(document.body.contains(this.querySelector("i.i2"))) {
							this.querySelector("i.i2").classList.remove("zmdi-chevron-down");
							this.querySelector("i.i2").classList.add("zmdi-chevron-up");
						}
						// Guarda en memoria el menu-item seleccionado
						valueMenuItem = this.dataset.menuItemId;
						sessionStorage.setItem(keyMenuItem, valueMenuItem);
					} 
					else {	// Cuando está activo el menú (abiertos los submenus)
						this.classList.remove("active");
						Animation.slideUp(submenuBox, 200);
						// Icono chevron up-down
						if(document.body.contains(this.querySelector("i.i2"))) {
							this.querySelector("i.i2").classList.remove("zmdi-chevron-up");
							this.querySelector("i.i2").classList.add("zmdi-chevron-down");
						}
						// Elimina de memoria el item seleccionado
						sessionStorage.removeItem(keyMenuItem);
					}
				}, false);
			}
		}
		/** Controla lo que debe hacer al hacer click en un item del submenu */
		function clickSubmenuItem() {
			for(var submenuItem of submenuItemList) {
				submenuItem.addEventListener('click', function() {
					this.classList.add("active");
					// Guarda en memoria el menu-item seleccionado
					valueSubmenuItem = this.dataset.submenuItemId;
					sessionStorage.setItem(keySubmenuItem, valueSubmenuItem);
				});
			}
		}
		/** 
		 * Restaura el menu-item seleccionado  
		 * @param{HTMLElement} menuItem
		 * @param{HTMLElement} submenuBox
		 */
		function restaurarMenuItem(menuItem, submenuBox) {
			menuItem.classList.add("active");
			Animation.slideDown(submenuBox, 0);	// Restaura a la velocidad de la luz
		}
		/** 
		 * Restaura el submenu-item seleccionado
		 * @param{HTMLElement} submenuItem
		 */
		function restaurarSubmenuItem(submenuItem) {
			submenuItem.classList.add("active");
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
				clickMenuItem();
				clickSubmenuItem();
			},
			/** Restaura los items seleccionados del menú o submenú cada vez que se hace refresh */
			restaurarItemsSeleccionados: function() {
				// Cuando haya algo seleccionado
				if(sessionStorage.length > 0) {
					valueMenuItem = sessionStorage.getItem(keyMenuItem);
					var menuItem = document.querySelector("a.menu-item[data-menu-item-id='"+valueMenuItem+"']");
					var submenuBox = menuItem.nextElementSibling;

					valueSubmenuItem = sessionStorage.getItem(keySubmenuItem);
					var submenuItem = submenuBox.querySelector("a.submenu-item[data-submenu-item-id='"+valueSubmenuItem+"']");
					restaurarMenuItem(menuItem, submenuBox);
					restaurarSubmenuItem(submenuItem);
				}
			}
		}		
	}
});