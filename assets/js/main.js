document.addEventListener('DOMContentLoaded', function() {
	"use strict";

	var menu = Menu();
	
	(function runMenu() {
		menu.clickMenuOpenIcon();
		menu.clickMenuCloseIcon();
		menu.clickAnyPlace();
		// menu.resizeEvent();
		menu.slideSubmenus();
		menu.restaurarItemsSeleccionados();
	})();

	var form = Form();
	form.validation();
	form.validationAllSelects();

	var formTrabajador = FormTrabajador();
	formTrabajador.selectBoxes();

	var formCargo = FormCargo();
	formCargo.selectBoxes();

	var formOficina = FormOficina();
	formOficina.selectBoxes();

	function Menu() {

		var menuSidebar = document.getElementById("sidebar-menu");
		var menuOpenIcon = document.querySelector(".mynavbar .zmdi-menu");
		var menuCloseIcon = document.querySelector("div.menu-title .zmdi-close");
		var menuItemList = document.getElementsByClassName("menu-item");
		var menuItemIconList = document.querySelectorAll(".menu-item > i.i2");
		var submenuItemList = document.querySelectorAll(".submenu-item");
		var submenuPanelList = document.querySelectorAll(".menu-item + div.submenu-box");

		var estadoMenu = true;				// true (menu activo), false (menu oculto)
		
		// "key" y "value", cookies que permiten al menú-sidebar no perder...
		// ... información de los items seleccionados cuando haya reload
		var keySession = {
			menuItemInd	: "menuItemInd",	// session para el menu-item seleccionado, independiente a todo
			submenuItem : "submenuItem",	// session para el submenu-item seleccionado
			menuItem 	: "menuItem"		// session para el menu-item seleccionado directamente relacionado al submenu-item
		}
		var valueSession = {
			menuItemInd	: undefined,
			submenuItem : undefined,
			menuItem 	: undefined
		}

		/** Muestra el menu */
		function showMenu() {
			if(window.innerWidth > SIZE_DEVICE.extraSmall)
				menuSidebar.style.transform = "translate(0, 0)";
			else
				menuSidebar.style.transform = "translate(0, 0)";
			estadoMenu = true;
		}
		/** Oculta el menu */
		function hideMenu() {
			if(window.innerWidth > SIZE_DEVICE.extraSmall)
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
						valueSession.menuItemInd = this.dataset.menuItemId;
						sessionStorage.setItem(keySession.menuItemInd, valueSession.menuItemInd);
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
						sessionStorage.removeItem(keySession.menuItemInd);
					}
				}, false);
			}
		}
		/** Controla lo que debe hacer al hacer click en un item del submenu */
		function clickSubmenuItem() {
			for(var submenuItem of submenuItemList) {
				submenuItem.addEventListener('click', function() {
					this.classList.add("active");
					// Guarda en memoria el submenu-item seleccionado
					valueSession.submenuItem = this.dataset.submenuItemId;
					sessionStorage.setItem(keySession.submenuItem, valueSession.submenuItem);

					var parent = this.parentElement;
					var menuItem = parent.previousElementSibling;
					// Guarda en memoria el menu-item seleccionado del submenu-item.
					valueSession.menuItem = menuItem.dataset.menuItemId;
					sessionStorage.setItem(keySession.menuItem, valueSession.menuItem);
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
			if(!estadoMenu && (window.innerWidth > SIZE_DEVICE.extraSmall))
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
		
				valueSession.menuItemInd = sessionStorage.getItem(keySession.menuItemInd);
				valueSession.submenuItem = sessionStorage.getItem(keySession.submenuItem);
				valueSession.menuItem = sessionStorage.getItem(keySession.menuItem);
				
				if(valueSession.menuItemInd) {
					var menuItem = document.querySelector("a.menu-item[data-menu-item-id='"+valueSession.menuItemInd+"']");
					var submenuBox = menuItem.nextElementSibling;
					restaurarMenuItem(menuItem, submenuBox);
				}
				if(valueSession.submenuItem && valueSession.menuItem) {
					var menuItem = document.querySelector("a.menu-item[data-menu-item-id='"+valueSession.menuItem+"']");
					var submenuBox = menuItem.nextElementSibling;
					var submenuItem = submenuBox.querySelector("a.submenu-item[data-submenu-item-id='"+valueSession.submenuItem+"']");
					restaurarSubmenuItem(submenuItem);
				}
			}
		}		
	}
	function Form() {
		var formsList = document.querySelectorAll('.needs-validation');
		var selectList = document.querySelectorAll('select.mySelectr');
		return {
			/* Validación de todos los inputs excepto los selects (Bootstrap css style)*/
			validation: function() {
				Array.prototype.slice.call(formsList).forEach(function (form) {
			      	form.addEventListener('submit', function (event) {
			        	if (!form.checkValidity()) {
			        	 	event.preventDefault();
			         	 	event.stopPropagation();
			        	}
			        	form.classList.add('was-validated');
			      	}, false);
				});
			},
			/*
			 * Crea un nuevo selector de la clase Selectr
			 * @param{HTMLElement} element
			 * @return[newSelectrObject]
			 */
			newSelectrDefault: function(element) {
				if(document.body.contains(element)) {
					var newSelector = new Selectr(element, {
						searchable: false,
						placeholder: "Seleccione...",
						messages: {
							noResults: "No resultados",
							noOptions: "No options"
						}
					});
					return newSelector;
				}
				return null;
			},
			/*
			 * Validación de todos los selects mediante estilos CSS
			 */
			validationAllSelects: function() {
				for(var form of formsList) {
				 	form.addEventListener('submit', function() {
						// Validación inicial de todos los select
						for(var select of selectList) {
							var parentContainer = select.parentElement;
							var selectContainer = parentContainer.querySelector('.selectr-selected');
							
							if(select.validity.valid)
								selectContainer.classList.add('selectr-valid');
							else
								selectContainer.classList.add('selectr-invalid');
						}

						// Validación perpetua de los selects
						for(var select of selectList) {
							select.addEventListener('change', function() {
								var parentContainer = this.parentElement;
								var selectContainer = parentContainer.querySelector('.selectr-selected');
								
								if(this.validity.valid) {
									selectContainer.classList.remove('selectr-invalid');
									selectContainer.classList.add('selectr-valid');
								}
								else {
									selectContainer.classList.remove('selectr-valid');
									selectContainer.classList.add('selectr-invalid');
								}	
							}, false);
						}
					}, false);
			 	}
			}
		}
	}

	function FormTrabajador() {
		// var formTrabajadorEl = document.getElementById('form-trabajador');
		var selectList = {
			lugarNacimiento : document.querySelectorAll('#form-trabajador .mySelectr.lugar-nacimiento'),
			cargo 	: document.querySelector('#form-trabajador .mySelectr.asignar-cargo')
		};
		var selectorList = {
			lugarNacimiento : [],
			cargo 			: undefined
		};
		/**
		 * Da estilo a los select-box con el plugin "Selectr" 
		 */
		function selectrPluginStyle() {
			// Select-boxes para el lugar de nacimiento (Region, Provincia, Distrito)
			for(var select of selectList.lugarNacimiento)
				selectorList.lugarNacimiento.push(form.newSelectrDefault(select));
			// Select para el Cargo
			selectorList.cargo = form.newSelectrDefault(selectList.cargo);
		}
		/*
		 * Llena los campos selects del 'lugar de nacimiento' cada que se...
		 * ...seleccione una opción (selects combinados) de (Region, Provincia, Distrito)
		 * NOTE: selectorList.lugarNacimiento => De tamaño Array(3) -->
		 * 									[0] => Region, [1] => Provincia, [2] => Distrito
		 */
		function llenarDataSelects() {
		 	// Para PROVINCIA
		 	var provincias = Object.keys(DEPARTAMENTO_PUNO);
			for(var provinciaName of provincias) {
				selectorList.lugarNacimiento[1].add({
					value: provinciaName,
					text: provinciaName
				});
			}
			// Para DISTRITO
			selectorList.lugarNacimiento[1].on('selectr.change', function(option) {
				var distritos = DEPARTAMENTO_PUNO[this.getValue()];
				selectorList.lugarNacimiento[2].removeAll();
				for(var distritoName of distritos) {
					selectorList.lugarNacimiento[2].add({
						value: distritoName,
						text: distritoName
					});
				}
			});
		}
		return {
		 	selectBoxes: function() {
			 	selectrPluginStyle();
		 		// Mientras el item del menú 'Crear-trabajador' no esté activa
		 		if(selectList.lugarNacimiento.length > 0)
			 		llenarDataSelects();
		 		
		 	}
		}
	}

	function FormCargo() {
		// var formCargoEl = document.getElementById('form-cargo');
		var selectList = {
			regimenLaboral: document.querySelector('#form-cargo .mySelectr.regimen-select'),
			oficinas: document.querySelectorAll('#form-cargo .mySelectr.asignar-oficina')
		};
		var selectorList = {
			oficinas: []
		}
		function selectrPluginStyle() {
			// Select para 'regimen laboral'
			form.newSelectrDefault(selectList.regimenLaboral);
			// Select-boxes para el la asignación de oficinas (Oficina, Suboficina)
			for(var select of selectList.oficinas)
				selectorList.oficinas.push(form.newSelectrDefault(select));
		}	
		return {
			selectBoxes: function() {
				// if(selectList.oficinas.length > 0)
					selectrPluginStyle();
			}
		}
	}

	function FormOficina() {
		var selectOficina = document.getElementById('oficina-jefe');
		// var selectorOficina = form.newSelectrDefault(selectOficina);
		function selectrPluginStyle() {
			// Select para 'oficina-padre'
			form.newSelectrDefault(selectOficina);
		}
		return {
			selectBoxes: function() {
				selectrPluginStyle();
			}
		}
	}
});