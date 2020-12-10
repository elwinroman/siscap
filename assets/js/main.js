document.addEventListener('DOMContentLoaded', function() {
	"use strict";

	var App = {
		menu: function() {
			var menu = Menu();
			menu.despliegueControl();
			menu.clickAnyPlace();
			menu.slideSubmenuControl();
			menu.restaurarItemsSeleccionados();
			menu.resizeEvent();
		},
		form: function() {
			var formulario = Form();
			formulario.validarInputs();
			formulario.validarSelects();
		},
		modulo: {
			trabajador: function() {
				FormTrabajador().selectrStyle();
			},
			cargo: function() {
				var cargo = Cargo();
				cargo.select();
				cargo.datatable();
			},
			oficina: function() {
				var oficina = Oficina();
				oficina.select();
				oficina.datatable();
				oficina.alerta();
			}
		}
	};
	App.menu();
	App.form();
	App.modulo.oficina();
	App.modulo.trabajador();
	App.modulo.cargo();
	
	/////////////////////////////////////////////////////////////////////////
	function Menu() {
		var menuSidebar = document.getElementById("sidebar-menu");
		var menuOpenIcon = document.querySelector(".mynavbar .zmdi-menu");
		var menuCloseIcon = document.querySelector("div.menu-title .zmdi-close");
		var menuItemList = document.getElementsByClassName("menu-item");
		var menuItemIconList = document.querySelectorAll(".menu-item > i.i2");
		var submenuItemList = document.querySelectorAll(".submenu-item");
		var submenuPanelList = document.querySelectorAll(".menu-item + div.submenu-box");
		var modalMain = document.getElementById("modal-main");
		var body = document.querySelector("body");

		// "key" y "value", cookies que permiten al menú-sidebar no perder
		// información de los items seleccionados cuando haya reload
		var keySession = {
			menuItemInd	: "menuItemInd",	// session para el menu-item seleccionado, independiente a todo
			submenuItem : "submenuItem",	// session para el submenu-item seleccionado
			menuItem 	: "menuItem"		// session para el menu-item seleccionado directamente relacionado al submenu-item
		};
		var valueSession = {
			menuItemInd	: undefined,
			submenuItem : undefined,
			menuItem 	: undefined
		};

		// Constructor
		(function construct() {
			if(menuSidebar.classList.contains("active"))
				modalMain.classList.add("on");

			scrollControl();
		})();

		// Controla el estado del scroll (mostrar-ocultar) dependiendo del tamaño
		function scrollControl() {
			var estadoMenu = menuSidebar.classList.contains("active") ? true : false; 					
			if(estadoMenu && window.innerWidth <= SIZE_DEVICE.extraSmall)
				body.style.overflow = "hidden";
			else 
				body.style.overflow = "auto";
		}
		// Muestra el menu
		function showMenu() {
			if(window.innerWidth > SIZE_DEVICE.extraSmall)
				menuSidebar.style.transform = "translate(0, 0)";
			else
				menuSidebar.style.transform = "translate(0, 0)";
			menuSidebar.classList.add("active");
		}
		// Oculta el menu
		function hideMenu() {
			if(window.innerWidth > SIZE_DEVICE.extraSmall)
				menuSidebar.style.transform = "translate(-101%, 0)";
			else
				menuSidebar.style.transform = "translate(0, -101%)";
			menuSidebar.classList.remove("active");
		}
		// Evento click en los items del menú
		function clickMenuItem() {
			for(var menuItem of menuItemList) {
				menuItem.addEventListener('click', function(event) {
					event.preventDefault();
					var submenuBox = this.nextElementSibling;
										
					// Cuando no esta activado
					if(this.classList.contains("active") === false) {
						ocultarSubmenus();
						Animation.slideDown(submenuBox, 200);
						helper_function.myRemoveClass(menuItemList, "active");
						this.classList.add("active");
						
						// Icono chevron up-down
						helper_function.myRemoveClass(menuItemIconList, "zmdi-chevron-up");
						helper_function.myAddClass(menuItemIconList, "zmdi-chevron-down");
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
				});
			}
		}
		// Evento click en los items del submenu
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
		 * @param {HTMLElement} menuItem
		 * @param {HTMLElement} submenuBox
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
		// Oculta todos los submenus
		function ocultarSubmenus() {
			submenuPanelList.forEach(function(submenuPanel) {
				Animation.slideUp(submenuPanel, 200);
			});
		}
		// Reposicionamiento del menu(sidebar)
		function reposicionarMenu() {
			var estadoMenu = menuSidebar.classList.contains("active") ? true : false; 
			if(!estadoMenu && (window.innerWidth > SIZE_DEVICE.extraSmall))
				menuSidebar.style.transform = "translate(-101%, 0)";
			else
				menuSidebar.style.transform = "translate(0, -101%)";
		}
		return {
			// Controla el despliegue del sidebar
			despliegueControl: function() {
				// abrir menú
				menuOpenIcon.addEventListener('click', function() {
					showMenu();
					modalMain.classList.add("on");

					if(window.innerWidth <= SIZE_DEVICE.extraSmall)
						body.style.overflow = "hidden";
				});

				// cerrar menú
				menuCloseIcon.addEventListener('click', function() {
					hideMenu();
					modalMain.classList.remove("on");

					if(window.innerWidth <= SIZE_DEVICE.extraSmall)
						body.style.overflow = "auto";
				});
			},
			// Cierra el menu al hacer click en cualquier parte excepto el menú
			clickAnyPlace: function() {
				modalMain.addEventListener('click', function() { 
					hideMenu(); 
					this.classList.remove("on");

					if(window.innerWidth > SIZE_DEVICE.extraSmall)
						body.style.overflow = "auto";
				});

				// Click en el navbar
				var myNavbar = document.querySelector("header > h3");
				myNavbar.addEventListener('click', function() { 
					hideMenu();
					modalMain.classList.remove("on");
				});
			},
			resizeEvent: function() {
				window.addEventListener('resize', function() {
					// reposicionarMenu();
					scrollControl();
				});
			},
			// Control de funcionalidades y efectos de items del menú
			slideSubmenuControl: function() {
				clickMenuItem();
				clickSubmenuItem();
			},
			// Restaura items seleccionados del menú o submenú cuando se realiza un reload
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
		/**
		 * Validación individual de cada select del plugin Selectr
		 * @param {DOMElement} select
		 */
		function validarSelect(select) {
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
			// Validación global de todos los inputs excepto <select> (Bootstrap css style)
			validarInputs: function() {
				Array.prototype.slice.call(formsList).forEach(function (form) {
			      	form.addEventListener('submit', function (event) {
			        	if (!form.checkValidity()) {
			        	 	event.preventDefault();
			         	 	event.stopPropagation();
			        	}
			        	form.classList.add('was-validated');
			      	});
				});
			},
			// Validación de todos los selects con estilos CSS
			validarSelects: function() {
				for(var form of formsList) {
				 	form.addEventListener('submit', function() {
						// Validación inicial de todos los selects
						selectList.forEach( (select) => { validarSelect(select); });

						// Validación perpetua de los selects
						selectList.forEach( (select) => {
							select.addEventListener('change', function() {
								validarSelect(this);
							});
						});
					});
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
	function Cargo() {
		var selectList = {
			regimenLaboral: document.querySelector('#form-cargo .mySelectr.regimen-select'),
			oficinaJefe: document.querySelector('#form-cargo .mySelectr[name="oficina-jefe"]'),
			suboficina: document.querySelector('#form-cargo .mySelectr[name="suboficina"]')
		};
		var selectrList = {
			regimenLaboral: Plugin.selectr(selectList.regimenLaboral),
			oficinaJefe: Plugin.selectr(selectList.oficinaJefe),
			suboficina: Plugin.selectr(selectList.suboficina)
		}
		var checkbox = document.querySelector("#form-cargo input[name='check']");
		var labelSelectSuboficina = document.querySelector("#form-cargo label[for='suboficina']");
 		
 		var tableCargo = document.getElementById('dt-cargo');
		var dtCargo;
		//////////////////////////////////////////////////////////////////////
		function selectOficinaJefe() {
			if(selectrList.oficinaJefe) {
				var peticionAjax = { peticion: "getOficinasJefe" };
				my_select_functions.cargarOficinas(selectrList.oficinaJefe, peticionAjax);
			}
		}
		function selectSuboficina() {
			if(selectrList.suboficina) {
				my_select_functions.desactivar(selectrList.suboficina, labelSelectSuboficina);
				my_select_functions.toggleSelect(checkbox, selectrList.suboficina, selectList.suboficina, labelSelectSuboficina);
				
				var idOficinaJefe;
				var peticionAjax;

				// Evento change para mostrar suboficinas de una oficina-jefe
				selectrList.oficinaJefe.on('selectr.change', function() {
					idOficinaJefe = parseInt(this.getValue());
					peticionAjax = { peticion: "getSuboficinasEspecificas", id: idOficinaJefe };
					
					selectrList.suboficina.removeAll();
					my_select_functions.cargarOficinas(selectrList.suboficina, peticionAjax);
				});
				// Evento change del checkbox para recargar suboficinas
				checkbox.addEventListener('change', function(event) {
					if(event.target.checked && peticionAjax !== undefined ) {
						selectrList.suboficina.removeAll();
						my_select_functions.cargarOficinas(selectrList.suboficina, peticionAjax);
					}
				});

			}
		}
		// Carga datos, inicializa el datatable para cargo y otras funcionalidades
		function datatableCargo() {
			// Obtener los datos para la tabla
			Ajax({
				method	: "POST",
				url		: "core/peticionesAjax.php",
				data 	: { 
					peticion: "getCargosList"
				}
			}).initRequest().then(function(result) {
				dtCargo = Plugin.datatable(tableCargo, JSON.parse(result));
				if(dtCargo) {
					var columnas = dtCargo.columns();
					var estadoColumnasVisibles = columnas.visible();
					columnas.sort([1]);	// Ordenar por #

					var nroColumna = {
						rowNumero: 0,
						rowChecked: undefined,
						rowLink: estadoColumnasVisibles.length-1
					};

					var nombreControlador = "Cargo";
					my_datatable_functions.definirEventos(dtCargo, columnas, 
							nroColumna, nombreControlador);

					// Visibilidad de columnas
					my_datatable_functions.generarCheckboxes(dtCargo);	
					my_datatable_functions.actualizarCheckboxes(dtCargo, columnas);
					// Oculta o muestra columnas clickando en un checkbox correspondiente
					my_datatable_functions.changeEventCheckboxes(columnas, nroColumna);
				}
			}).catch(function(error) {
				alert(error);
			});
		}
		return {
			select: function() {
				selectOficinaJefe();
				selectSuboficina();
			},
			datatable: function() {
				datatableCargo();
			}
		}
	}
	function Oficina() {
		var checkbox = document.querySelector("#form-oficina input[name='check']");
		var oficinaJefe = {
			labelSelect: document.querySelector("#form-oficina label[for='oficina-jefe']"),
			select: document.querySelector("#form-oficina .mySelectr[name='oficina-jefe']"),
			selectr: undefined
		};
		oficinaJefe.selectr = Plugin.selectr(oficinaJefe.select);

		var tableOficina = document.getElementById('dt-oficina');
		var dtOficina;
		////////////////////////////////////////////////////////////////////////////

		// Control para select-oficina-jefe
		function selectOficinaJefe() {
			if(oficinaJefe.selectr) {
				var peticionAjax = {peticion: "getOficinasJefe"};
				my_select_functions.desactivar(oficinaJefe.selectr, oficinaJefe.labelSelect);
				my_select_functions.toggleSelect(checkbox, oficinaJefe.selectr, oficinaJefe.select, oficinaJefe.labelSelect);
				checkbox.addEventListener('change', function(event) {
					if(event.target.checked)
						my_select_functions.cargarOficinas(oficinaJefe.selectr, peticionAjax);
				});

			}
		}
		// Carga datos, inicializa el datatable para oficina y otras funcionalidades
		function datatableOficina() {
			// Obtener los datos para la tabla
			Ajax({
				method	: "POST",
				url		: "core/peticionesAjax.php",
				data 	: { 
					peticion: "getOficinasList"
				}
			}).initRequest().then(function(result) {
				dtOficina = Plugin.datatable(tableOficina, JSON.parse(result));
				if(dtOficina !== null ) {

					var columnas = dtOficina.columns();
					columnas.sort([1]);		// Ordenar por #

					var estadoColumnasVisibles = columnas.visible();
					var nroColumna = {
						rowNumero: 0,
						rowChecked: undefined,
						rowLink: estadoColumnasVisibles.length-1
					};

					var nombreControlador = "Oficina";
					my_datatable_functions.definirEventos(dtOficina, columnas, 
							nroColumna, nombreControlador);

					// Visibilidad de columnas
					my_datatable_functions.generarCheckboxes(dtOficina);	
					my_datatable_functions.actualizarCheckboxes(dtOficina, columnas);
					// Oculta o muestra columnas clickando en un checkbox correspondiente
					my_datatable_functions.changeEventCheckboxes(columnas, nroColumna);
				}
			}).catch(function(error) {
				alert(error);
			});
		}

		return {
			select: function() {
				selectOficinaJefe();
			},
			datatable: function() {
				datatableOficina();
			},
			alerta: function() {
				var alertaCrearOficina = document.getElementById("alerta-crear-oficina");
				if(document.body.contains(alertaCrearOficina)) {
					var alerta = alertaCrearOficina.innerHTML.trim();
					if(alerta === "success")
						alert("Se ha creado correctamente una oficina");
					else if(alerta === "unsuccess")
						alert("No se ha podido crear error---");
				}
			}
		}
	}

	var my_datatable_functions = {
		/** 
		 * Redirecciona un item del datatable para mostrar con más detalles usando su ID
		 * @param {String} controlador
		 */
		redireccionarConID: function(controlador) {
			var linkList = document.querySelectorAll('.dataTable-table i.icon-datatable-link');
			for(var link of linkList) {
				link.addEventListener('click', function() {
					var id = this.dataset.id;
					location.href = '?controller='+controlador+'&action=mostrar&id='+id;
				});
			}
		},
		/**
		 * Actualiza la visibilidad de columnas de los checkboxes dependiendo de la visibilidad inicial del datatable
		 * @param {Datatable} datatable
		 * @param {Datatable.columns()} columnas
		 */
		actualizarCheckboxes: function(datatable, columnas) {
			var checkboxList = document.querySelectorAll("#checkbox-container input.form-check-input");
			var estadoColumnasVisibles = columnas.visible();
			var i = 0;
			for(var estado of estadoColumnasVisibles) {
				checkboxList[i].checked = estado;
				i++;
			}
		},
		/**
		 * Identifica las columnas (#) y (Ver)
		 * @param {Datatable.columnas()} columnas
		 * @param {Object} nroColumna 
		 */
		identificarColumnasEspeciales: function(columnas, nroColumna) {
			var estadoColumnasVisibles = columnas.visible();
			// Si la columna(#) está visible
			if(estadoColumnasVisibles[nroColumna.rowNumero] === true ) {
				var thNumber = document.querySelector(".dataTable-table > thead > tr > th:first-child");
				var tdNumberList = document.querySelectorAll(".dataTable-table > tbody > tr > td:first-child");
				thNumber.classList.add("special-column");
				tdNumberList.forEach(function(tdNumber) {
					tdNumber.classList.add("special-column");
				});
			}
			// Si la columna(Ver) está visible
			if(estadoColumnasVisibles[nroColumna.rowLink] === true) {
				var thLink = document.querySelector(".dataTable-table > thead > tr > th:last-child");
				var tdLinkList = document.querySelectorAll(".dataTable-table > tbody > tr > td:last-child");	
				thLink.classList.add("special-column");
				tdLinkList.forEach(function(tdLink) {
					tdLink.classList.add("special-column");
				});
			}
		},
		/**
		 * Define propiedades predefinidas para todos los eventos
		 * @param {Datatable} datatable
		 * @param {Datatable.columns()} columnas
		 * @param {Object} nroColumna
		 * @param {String} nombreControlador
		 */
		definirEventos: function(datatable, columnas, nroColumna, nombreControlador) {;
			var self = this;
			datatable.on('datatable.init', function() {
				self.identificarColumnasEspeciales(columnas, nroColumna);
				self.redireccionarConID(nombreControlador);
			});
			datatable.on('datatable.page', function() {
				self.identificarColumnasEspeciales(columnas, nroColumna);
				self.redireccionarConID(nombreControlador);
			});
			datatable.on('datatable.sort', function() {
				self.identificarColumnasEspeciales(columnas, nroColumna);
				self.redireccionarConID(nombreControlador);
			});
			datatable.on('datatable.search', function() {
				self.identificarColumnasEspeciales(columnas, nroColumna);
				self.redireccionarConID(nombreControlador);
			});
		},
		/**
		 * Controla la visibilidad de las columnas cada que se haga check/uncheck en los checkboxes correspondientes
		 * @param {Datatable.columns()} columnas
		 * @param {Object} nroColumna 
		 */
		changeEventCheckboxes: function(columnas, nroColumna) {
			var checkboxList = document.querySelectorAll("#checkbox-container input.form-check-input");
			var self = this;
			// evento change en los inputs checkbox
			checkboxList.forEach(function(checkbox) {
				checkbox.addEventListener('change', function() {
					nroColumna.rowChecked = parseInt(this.value);
					if(this.checked)
						columnas.show([nroColumna.rowChecked]);
					else
						columnas.hide([nroColumna.rowChecked]);

					self.identificarColumnasEspeciales(columnas, nroColumna);					
				});
			});
		},
		/**
		 * Genera dinamicamente checkboxes para ocultar o mostrar columnas
		 * @param {Datatable} datatable 
		 */
		generarCheckboxes: function(datatable) {
			var crearElemento = {
				div: function() {
					var div = document.createElement("div");
					var attrClass = document.createAttribute("class");
					attrClass.value = "form-check form-check-inline";
					div.setAttributeNode(attrClass);
					return div;
				},
				input: function(valor) {
					var input = document.createElement("input");
					var attrClass = document.createAttribute("class");
					var attrType = document.createAttribute("type");
					var attrValue = document.createAttribute("value");
					attrClass.value = "form-check-input";
					attrType.value = "checkbox";
					attrValue.value = valor;
					input.setAttributeNode(attrType);
					input.setAttributeNode(attrClass);
					input.setAttributeNode(attrValue);
					return input;	
				},
				label: function(nombreColumna) {
					var label = document.createElement("label");
					var attrClass = document.createAttribute("class");
					attrClass.value = "form-check-label";
					label.innerHTML = nombreColumna;
					return label;
				}
			}
			var cont = 0;
			var headingsList = datatable.headings;
			var checkboxContainer = document.getElementById("checkbox-container");
			headingsList.forEach(function(heading) {
				var checkbox = crearElemento.div();
				var input = crearElemento.input(cont);
				var label = crearElemento.label(heading.textContent);
				checkboxContainer.appendChild(checkbox);
				checkbox.appendChild(input);
				checkbox.appendChild(label);
				cont++;
			});	
		}
	}
});

var my_select_functions = {
	/**
	 * Desactiva el select y label
	 * @param {Selectr} selectr
	 * @param {HTMLElement} labelSelect
	 */
	desactivar: function(selectr, labelSelect) {
		selectr.disable();
		labelSelect.classList.add('label-disabled');
	},
	/**
	 * Controla el estado disable/enable del select dependiendo del checkbox
	 * @param {HTMLElement} checkbox
	 * @param {Selectr} selectr
	 * @param {HTMLElement} select
	 * @param {HTMLElement} labelSelect
	 */
	toggleSelect: function(checkbox, selectr, select, labelSelect) {
		checkbox.addEventListener('change', function(event) {
			var parentContainer = select.parentElement;
			var selectContainer = parentContainer.querySelector('.selectr-selected');
			if(event.target.checked) {
				selectr.enable();
				select.setAttribute('required','');
				labelSelect.classList.remove('label-disabled');
				selectContainer.classList.add('selectr-invalid');
			} else {
				selectr.removeAll();
				selectr.disable();
				labelSelect.classList.add('label-disabled');
				select.removeAttribute('required');
				selectContainer.classList.remove('selectr-invalid');
			}
		});
	},
	/**
	 * Carga oficinas en el Select desde AJAX
	 * @param {Selectr} selectr
	 * @param {Object} peticionAjax
	 */
	cargarOficinas: function(selectr, peticionAjax) {
		Ajax({
			method 	: "POST",
			url 	: "core/peticionesAjax.php",
			data 	: Object.assign({}, peticionAjax)
		}).initRequest().then(function(result) {
			var data = JSON.parse(result);
			data.forEach((oficina) => {
				selectr.add({
					value: oficina.value,
					text: oficina.name
				});
			});
			// console.log(result);
		}).catch(function(error) {
			console.log(error);
			selectr.disable();
		});
	}
}