document.addEventListener('DOMContentLoaded', function() {
	"use strict";

	var App = {
		menu: function() {
			var menu = Menu();
			menu.clickMenuOpenIcon();
			menu.clickMenuCloseIcon();
			menu.clickAnyPlace();
			menu.slideSubmenus();
			menu.restaurarItemsSeleccionados();
		},
		forms: function() {
			var formulario = Form();
			formulario.validation();
			formulario.validationAllSelects();

			FormTrabajador().selectrStyle();
			FormCargo().selectrStyle();
			FormOficina().selectHandler();
		}
	};
	App.menu();
	App.forms();
	
	/////////////////////////////////////////////////////////////////////////
	function Menu() {

		var menuSidebar = document.getElementById("sidebar-menu");
		var menuOpenIcon = document.querySelector(".mynavbar .zmdi-menu");
		var menuCloseIcon = document.querySelector("div.menu-title .zmdi-close");
		var menuItemList = document.getElementsByClassName("menu-item");
		var menuItemIconList = document.querySelectorAll(".menu-item > i.i2");
		var submenuItemList = document.querySelectorAll(".submenu-item");
		var submenuPanelList = document.querySelectorAll(".menu-item + div.submenu-box");

		var estadoMenu = true;				// true (menu activo), false (menu oculto)
		
		// "key" y "value", cookies que permiten al menú-sidebar no perder
		// información de los items seleccionados cuando haya reload
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
			estadoMenu = true;
			if(window.innerWidth > SIZE_DEVICE.extraSmall)
				menuSidebar.style.transform = "translate(0, 0)";
			else
				menuSidebar.style.transform = "translate(0, 0)";
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
		 * @param {string} nameClass		   => Nombre de clase
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
		var selectList = document.querySelectorAll('select');
		/**
		 * Validación individual de cada select
		 * @param{DOMElement} select
		 */
		function validacionIndividual(select) {
			var parentContainer = select.parentElement;
			var selectContainer = parentContainer.querySelector('.selectr-selected');
			
			if(select.validity.valid) {
				selectContainer.classList.remove('selectr-invalid');
				selectContainer.classList.add('selectr-valid');
			}
			else {
				selectContainer.classList.remove('selectr-valid');
				selectContainer.classList.add('selectr-invalid');
			}
		}
		return {
			/** 
			 * Validación de todos los inputs excepto los selects (Bootstrap css style) 
			 */
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
			/** 
			 * Validación de todos los selects con estilos CSS 
			 */
			validationAllSelects: function() {
				for(var form of formsList) {
				 	form.addEventListener('submit', function() {
						// Validación inicial de todos los selects
						selectList.forEach( (select) => { validacionIndividual(select); });

						// Validación perpetua de los selects
						selectList.forEach( (select) => {
							select.addEventListener('change', function() {
								validacionIndividual(this);
							}, false);
						});
					}, false);
			 	}
			}
		}
	}

	function FormTrabajador() {
		var selectList = {
			lugarNacimiento: document.querySelectorAll('#form-trabajador .mySelectr.lugar-nacimiento'),
			cargo: document.querySelector('#form-trabajador .mySelectr.asignar-cargo')
		};
		var selectorList = {
			lugarNacimiento: [],
			cargo: undefined
		};
		/**
		 * Llena de opciones los selects del 'lugar de nacimiento' cada que se seleccione una opción
		 * opción (selects combinados) de (Region, Provincia, Distrito)
		 * [0] => Region, [1] => Provincia, [2] => Distrito
		 */
		function llenarDataSelects() {
			if(selectList.lugarNacimiento.length > 0) {
			 	// Para PROVINCIA
			 	var provincias = Object.keys(DEPARTAMENTO_PUNO);
			 	provincias.forEach(function(provinciaName) {
					selectorList.lugarNacimiento[1].add({
						value: provinciaName,
						text: provinciaName
					});
				});
				// Para DISTRITO
				selectorList.lugarNacimiento[1].on('selectr.change', function(option) {
					var distritos = DEPARTAMENTO_PUNO[this.getValue()];
					selectorList.lugarNacimiento[2].removeAll();
					distritos.forEach(function(distritoName) {
						selectorList.lugarNacimiento[2].add({
							value: distritoName,
							text: distritoName
						});
					});
				});
			}
		}
		return {
		 	selectrStyle: function() {
			 	// Selectr para el lugar de nacimiento (Region, Provincia, Distrito)
				for(var select of selectList.lugarNacimiento)
					selectorList.lugarNacimiento.push(Plugin.selectr(select));
				// Select para el Cargo
				selectorList.cargo = Plugin.selectr(selectList.cargo);
				llenarDataSelects();
		 	}
		}
	}
	function FormCargo() {
		var selectList = {
			regimenLaboral: document.querySelector('#form-cargo .mySelectr.regimen-select'),
			oficinas: document.querySelectorAll('#form-cargo .mySelectr.asignar-oficina')
		};
		return {
			selectrStyle: function() {
				// Select para 'regimen laboral'
				Plugin.selectr(selectList.regimenLaboral);
				// Select-boxes para el la asignación de oficinas (Oficina, Suboficina)
				for(var select of selectList.oficinas)
					Plugin.selectr(select);
			}
		}
	}
	function FormOficina() {
		var checkbox = document.querySelector("#form-oficina input[name='check']");
		var labelSelectOficina = document.querySelector("#form-oficina label[for='oficina']");
		var selectOficina = document.getElementById('sct-oficina-jefe');
		var selectorOficina = Plugin.selectr(selectOficina);

		/**
		 * Llena con datos select-oficina
		 */
		function llenarSelectOficina() {
			var ajaxConfig = {
				method: "POST",
				url: "core/peticionesAjax.php",
				data: { peticion: 'getOficinasJefe' }
			};
			var ajax = new Ajax(ajaxConfig);
			ajax.initRequest().then((result) => {
				var data = JSON.parse(result); 
				data.forEach((oficina) => {
					selectorOficina.add({
						value: oficina.value,
						text: oficina.name
					});
				});
			}).catch((error) => {
				console.log(error);
				selectorOficina.disable();
			});
		}
		/**
		 * Handler for selectOficina
		 */
		function selectOficinaHandler() {
			if(selectorOficina !== null) {
				selectorOficina.disable();
				labelSelectOficina.classList.add('label-disabled');

				// Activa o desactiva el select oficina-jefe
				checkbox.addEventListener('change', function(event) {
					var parentContainer = selectOficina.parentElement;
					var selectContainer = parentContainer.querySelector('.selectr-selected');
					if(event.target.checked) {
						selectorOficina.enable();
						llenarSelectOficina();
						selectOficina.setAttribute('required','');
						labelSelectOficina.classList.remove('label-disabled');

						selectContainer.classList.add('selectr-invalid');
					} else {
						selectorOficina.removeAll();
						selectorOficina.disable();
						labelSelectOficina.classList.add('label-disabled');
						selectOficina.removeAttribute('required');

						selectContainer.classList.remove('selectr-invalid');
					}
				}, false);
			}
		}
		return {
			selectHandler: function() {
				selectOficinaHandler();
			}
		}
	}
});