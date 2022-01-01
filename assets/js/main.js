document.addEventListener('DOMContentLoaded', function() {	
"use strict";

var App = {
	menu: function() {
		var menu = Menu();
		menu.init();
		menu.main();
	},
	navbar: function() {
		var navbar = Navbar();
		navbar.init();
		navbar.main();
		// navbar.buttons();
		// navbar.resize();
		// navbar.scroll();
	},
	form: function() {
		var formulario = Form();
		formulario.validarInputs();
		formulario.validarSelects();
	},
	modulo: {
		trabajador: function() {
			var trabajador = Trabajador();
			trabajador.crear();
			trabajador.alertas();
		},
		cargo: function() {
			var cargo = Cargo();
			cargo.init();
			cargo.crear();
			cargo.listar();
			cargo.mostrar();
			cargo.editar();
			cargo.alertas();
		},
		oficina: function() {
			var oficina = Oficina();
			oficina.init();
			oficina.crear();
			oficina.listar();
			oficina.editar();
			oficina.alertas();
		}
	},
	bootstrap5: {
		// Inicializar todos los tooltips (Bootstrap v5)
		tooltip: function() {
			var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
			var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
				return new bootstrap.Tooltip(tooltipTriggerEl);
			});
		},
		// Inicializar todos los dropdowns (Bootstrap v5)
		dropdown: function() {
			var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
			var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
				return new bootstrap.Dropdown(dropdownToggleEl);
			});
		},
		mymodal: function() {
			window.addEventListener("scroll", function() {
				// Elimina el scroll del modal
				var modal_dialog = document.querySelector(".modal-dialog");
				if(window.innerWidth <= 576 && modal_dialog)
					modal_dialog.classList.remove("modal-dialog-scrollable");
			});
		}
	}
};
App.menu();
App.navbar();
App.form();
App.bootstrap5.tooltip();
App.bootstrap5.dropdown();
App.bootstrap5.mymodal();
App.modulo.oficina();
App.modulo.trabajador();
App.modulo.cargo();

/////////////////////////////////////////////////////////////////////////
function Menu() {
	var menu = document.querySelector("nav.sidebar");
	var menu_toggle = document.querySelector("nav.navbar-custom .zmdi-menu");
	var menuItemList = document.querySelectorAll("a.menu-item");
	var menuItemArrowList = document.querySelectorAll("a.menu-item > i.i-arrow");
	var submenuBoxList = document.querySelectorAll("ul.submenu-box");
	var submenuItemList = document.querySelectorAll("li > a.submenu-item");

	var menu_status = undefined;		// Guarda el estado del sidebar-menu

	// Listeners de todos los eventos
	var listener = { 
		click: {
			/* Efecto toggle para el menu-item */
			menuItem: function(event) {
				event.preventDefault();
				var submenuBox = this.nextElementSibling;
				
				// Colapsa el menu clickeado si está expandido
				if(this.classList.contains("active")) {
					this.classList.remove("active");
					this.querySelector("i.i-arrow").classList.remove("zmdi-hc-rotate-90");
					Animation.collapse(submenuBox, 200);
				} else { 
				// Expande el menu clickeado colapsando los demás
					resetMenu(200);
					this.classList.add("active");
					this.querySelector("i.i-arrow").classList.add("zmdi-hc-rotate-90");
					Animation.expand(submenuBox, 200);
				}
			},
			submenuItem: function() {
				this.classList.add("active");
				// Guarda en memoria el submenu-item seleccionado
				var value = this.dataset.submenuItemId;
				sessionStorage.setItem("submenu-item", value);

				var li = this.parentElement;
				var ul = li.parentElement;
				var menuItem = ul.previousElementSibling;

				// Guarda en memoria el menu-item padre del submenu-item seleccionado.
				value = menuItem.dataset.menuItemId;
				sessionStorage.setItem("menu-item", value);
			},
			/* Efecto toggle del menu-sidebar (pequeño-grande) */
			toggleMenu: function() {
				if(menu_status === "shortened") {
					sessionStorage.setItem("menu", "normal");
					menu_status = "normal";
					regularMenu();
				} else {
					sessionStorage.setItem("menu", "shortened");
					menu_status = "shortened";
					miniMenu();
				}
			}
		},
		resize: {
			menu: function() {
				if(window.innerWidth <= 768) {	// medium
					menu_toggle.style.display = "none";
					miniMenu();
				} else {
					menu_toggle.style.display = "block";
					if(menu_status === "normal")
						regularMenu();
					else
						miniMenu();
				}
			}
		}
	};

	var evento = {
		click: {
			burguerIcon: function() {
				menu_toggle.addEventListener("click", listener.click.toggleMenu);
			},
			add: {
				menuItem: function() {
					for(var menu_item of menuItemList)
						menu_item.addEventListener("click", listener.click.menuItem);
				},
				submenuItem: function() {
					for(var submenu_item of submenuItemList)
						submenu_item.addEventListener("click", listener.click.submenuItem);
				},
			},
			remove: {
				menuItem: function() {
					for(var menu_item of menuItemList)
					menu_item.removeEventListener("click", listener.click.menuItem);
				}
			}
		},
		resize: {  
			menu: function() {
				window.addEventListener("resize", listener.resize.menu);
			}
		},
		mousehover: {
			submenuItem: function() {
				for(var submenubox of submenuBoxList) {
					submenubox.addEventListener("mouseover", function() {
						var menu_itemM = this.previousElementSibling;
						var descripcion = menu_itemM.querySelector("span");
						descripcion.classList.add("show");
					});
					submenubox.addEventListener("mouseout", function() {
						var menu_itemM = this.previousElementSibling;
						var descripcion = menu_itemM.querySelector("span");
						descripcion.classList.remove("show");
					});
				}
			}
		}
	};
	// Muestra el menú-sidebar normal
	function regularMenu() {
		evento.click.add.menuItem();
		restaurarMenuItems();
		document.body.classList.remove("shortened");
	}
	// Muestra el menu-sidebar pequeño
	function miniMenu() {
		evento.click.remove.menuItem();
		restaurarMenuItems();
		resetMenu(0);
		document.body.classList.add("shortened");
	}
	/**
	 * Colapsa todos los menus abiertos y remueve estilos
	 * @param{Integer} speed - Velocidad de colapse en milisegundos
 	 */
	function resetMenu(speed) {
		for(var menu_item of menuItemList)
			menu_item.classList.remove("active");
		for(var arrow of menuItemArrowList)
			arrow.classList.remove("zmdi-hc-rotate-90");
		for(var submenu_box of submenuBoxList)
			Animation.collapse(submenu_box, speed);
	}
	// Restaura items seleccionados del menú o submenú cuando se realiza un reload
	function restaurarMenuItems() {
		var sessionval_menu_item = sessionStorage.getItem("menu-item");
		var sessionval_submenu_item = sessionStorage.getItem("submenu-item");

		if(sessionval_menu_item) {
			var menu_item = document.querySelector("a.menu-item[data-menu-item-id='"
													+sessionval_menu_item+"']");
			var submenu_box = menu_item.nextElementSibling;
			var submenu_item = submenu_box.querySelector("a.submenu-item[data-submenu-item-id='"+
												sessionval_submenu_item+"']");
			// Restaura menus
			menu_item.classList.add("active");
			menu_item.querySelector("i.i-arrow").classList.add("zmdi-hc-rotate-90");
			Animation.expand(submenu_box, 0);

			// Restaura submenu
			if(sessionval_submenu_item)
				submenu_item.classList.add("active");
		}
	}
	return {
		init: function() {
			menu_status = sessionStorage.getItem("menu");
			if(menu_status === null) menu_status = "normal";
			evento.click.add.submenuItem();
			listener.resize.menu();
		},
		main: function() {
			evento.click.burguerIcon();
			evento.resize.menu();
			evento.mousehover.submenuItem();
		}
	}		
}
function Navbar() {
	var navbar = document.querySelector("nav.navbar-custom");
	var theme_icon = document.querySelector(".navbar-custom li.theme > i");
	var main = document.querySelector("main.wrapper");
	var body = document.body;

	var listener = {
		// Cambia el estilo de la página, MODO OSCURO y MODO CLÁSICO
		changeTheme: function() {
			if(body.classList.contains("light")) {
				body.classList.remove("light");
				body.classList.add("dark");
				sessionStorage.setItem("cookie_theme", "dark");
			} else {
				body.classList.remove("dark");
				body.classList.add("light");
				sessionStorage.setItem("cookie_theme", "light");
			}
		}
	}
	var evento = {
		theme_icon: function() {
			theme_icon.addEventListener("click", listener.changeTheme);
		},
		scroll: function() {
			main.addEventListener("scroll", listener.navbarSticky);
		}
	};
	return {
		init: function() {
			var value_theme = sessionStorage.getItem("cookie_theme");
			if(value_theme === "dark")
				body.classList.add("dark");
			else	// default
				body.classList.add("light");
		},
		main: function() {
			evento.theme_icon();
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

function Trabajador() {
	var selectList = {
		lugar_residencia: document.querySelectorAll('#form-trabajador .mySelectr.lugar-residencia'),
		cargo: document.querySelector('#form-trabajador .mySelectr.asignar-cargo'),
		tipo_seguro: document.querySelector('#form-trabajador .mySelectr.tipo-seguro'),
		condicion_contrato: document.querySelector('#form-trabajador .mySelectr.condicion-contrato')
	};
	var selectorList = {
		lugar_residencia: [],
		cargo: undefined,
		tipo_seguro: undefined,
		condicion_contrato: undefined
	};
	// var alerta = Alerta();

	function selectLugarNacimiento() {
		if(selectList.lugar_residencia.length > 0) {
			// Selectr para el lugar de residencia (Region, Provincia, Distrito)
			for(var select of selectList.lugar_residencia)
				selectorList.lugar_residencia.push(Plugin.selectr(select));
		 	
		 	// Llenar datos para PROVINCIA
		 	var provincias = Object.keys(DEPARTAMENTO_PUNO);
		 	provincias.forEach(function(provinciaName) {
				selectorList.lugar_residencia[1].add({
					value: provinciaName,
					text: provinciaName
				});
			});
			// Llenar datos para DISTRITO
			selectorList.lugar_residencia[1].on('selectr.change', function(option) {
				var distritos = DEPARTAMENTO_PUNO[this.getValue()];
				selectorList.lugar_residencia[2].removeAll();
				distritos.forEach(function(distritoName) {
					selectorList.lugar_residencia[2].add({
						value: distritoName,
						text: distritoName
					});
				});
			});
		}	
	}
	function selectCargo() {
		if(document.body.contains(selectList.cargo)) {
			selectorList.cargo = Plugin.selectr(selectList.cargo);
			Ajax({
				method	: "POST",
				url 	: "core/peticionesAjax.php",
				data 	: {
					peticion: "obtener_cargos_vacantes"
				}
			}).initRequest().then(function(result) {
				var data = JSON.parse(result);
				data.forEach(function(data) {
					selectorList.cargo.add({
						value: data['id'],
						text: data['nro_plaza'] + ' ' + data['nombre']
					});
				});	
			});
		}
	}
	function selectTipoSeguro() {
		if(document.body.contains(selectList.tipo_seguro)) {	
			selectorList.tipo_seguro = Plugin.selectr(selectList.tipo_seguro);
			SISTEMA_PENSIONES.forEach(function(seguro) {
				selectorList.tipo_seguro.add({
					value: seguro,
					text: seguro
				});
			});
		}
	}
	function selectCondicionContrato() {
		if(document.body.contains(selectList.condicion_contrato)) {
			selectorList.condicion_contrato = Plugin.selectr(selectList.condicion_contrato);
			CONDICION_CONTRATO.forEach((contrato)=>{
				selectorList.condicion_contrato.add({
					value: contrato,
					text: contrato
				});
			});
		}
	}
	return {
	 	crear: function() {
			selectLugarNacimiento();
			selectCargo();
			selectTipoSeguro();
			selectCondicionContrato();
	 	},
	 	alertas: function() {
			// crear trabajador y asignar cargo
			/*var alertaCrear = {
				element 	: document.getElementById("alerta-crear-trabajador"),
				textSuccess : "Se ha creado correctamente el trabajador "+
							  "y se ha asignado su cargo.",
				textError 	: "No se ha podido crear correctamente el trabajador."
			};
			alerta.crear(alertaCrear.element, alertaCrear.textSuccess, alertaCrear.textError);
			// msg de error de asignación de fechas
			var alertaErrorFechas = document.getElementById("alerta-error-fechas");
			if(document.body.contains(alertaErrorFechas)) {
				Swal.fire({
				 	title: 'Error',
				 	text: 'Una o ambas fechas de asignación son inválidas. Revise e ingrese nuevamente',
					icon: 'error',
					confirmButtonText: 'Aceptar'
				});
			}*/
	 	}
	}
}
function Cargo() {
	// ############## Atributos ##############
	var select1_element = {		// select oficina_jefe
		select: document.querySelector('#form-cargo .mySelectr[name="oficina-jefe"]'),
		selector: null,
		value: null		// <option selected>
	};
	var select2_element = {		// select suboficina
		select: document.querySelector('#form-cargo .mySelectr[name="suboficina"]'),
		selector: null,
		label: document.querySelector("#form-cargo label[for='suboficina']"),
		value: null		// <option selected>
	};
	var checkbox = document.querySelector("#form-cargo input[name='check']");
	var labelSelectSuboficina = document.querySelector("#form-cargo label[for='suboficina']");
		
	var tableCargo = document.getElementById('dt-cargo');
	var dt_cargo;
	var data_table;
	
	var id_oficina_jefe = null;
	var alerta_crear = document.getElementById("alerta-crear-cargo");
	var alerta_eliminar = document.getElementById("alerta-eliminar-cargo");
	var alerta_editar = document.getElementById("alerta-editar-cargo");

	var btn_limpiar = document.querySelector("#crear-cargo button.btn-limpiar");
	var btn_eliminar = document.querySelector("#mostrar-cargo button.btn-eliminar");

	/* Info about datatable columns
	 * 0 => numero de orden
	 * 2 => nro de plaza
	 * 5 => cargo confianza
	 * 6 => cargo jefe
	 * 7 => link
	 */
	var info_dt = {
		index: [0, 2, 3, 5, 6, 7],
		class: ["num-column", "nro-plaza-column", "trabajador-column",
				"cargo-confianza-column", "cargo-jefe-column", "link-column"]
	}
	// ############## End of atributos ##############

	var listener = {
		change: {
			// Carga suboficinas a travez del ID de la oficina-jefe
			loadSuboficinas: function() {
				id_oficina_jefe = parseInt(select1_element.selector.getValue());
				select2_element.selector.removeAll();
				SELECTR.cargarOficinas(select2_element.selector, {
					peticion: "get_suboficinas",
					id: id_oficina_jefe
				}, null);
			},
			toggleSuboficina: function() {
				if(checkbox.checked) {
					SELECTR.enableSelect(select2_element);
					if(id_oficina_jefe !== null) 
						listener.change.loadSuboficinas();
				} else
					SELECTR.disableSelect(select2_element);
			}
		}
	};
	var evento = {
		change: {
			checkbox: function() {
				var crear_oficina = document.querySelector('#crear-cargo');
				var modal_editar_oficina = document.querySelector('#modal-editar-cargo');
				if(crear_oficina || modal_editar_oficina)
					checkbox.addEventListener("change", listener.change.toggleSuboficina);
			},
			// Evento change en el select oficina-jefe
			selectOficinaJefe: function() {
				select1_element.selector.on('selectr.change', listener.change.loadSuboficinas);
			}
		},
		click: {
			buttonLimpiar: function(msg) {
				btn_limpiar.addEventListener("click", function() {
					SWEET_ALERT.resetearFormulario(msg);
				});
			},
			buttonEliminar: function(msg) {
				btn_eliminar.addEventListener("click", function() {
					var url = "?controller=Cargo&action=eliminar&id=";
					var id = this.value;
					SWEET_ALERT.eliminar(msg, url, id);
				});
			},
			exportable: {
				pdfButton: function(pdf_button) {
					pdf_button.addEventListener("click", function() {
						data_table = Object.assign({}, EXPORTABLE.organizarData(dt_cargo));
						EXPORTABLE.exportToPDF(data_table, "pdfcommand");
					});
				},
				excelButton: function(excel_button) {
					excel_button.addEventListener("click", function() {
						data_table = Object.assign({}, EXPORTABLE.organizarData(dt_cargo));
						EXPORTABLE.exportToExcel(data_table.body);
					});	
				},
				printButton: function(print_button) {
					print_button.addEventListener("click", function() {
						data_table = Object.assign({}, EXPORTABLE.organizarData(dt_cargo));
						EXPORTABLE.exportToPdf(data_table, "printcommand");
					});
				}
			},
			// Reinicia los datos iniciales al cerrar un modal
			closeModal: function() {
				var close_modal = document.querySelector("#modal-editar-cargo button.btn-close");
				if(close_modal) close_modal.addEventListener("click", ()=>{ location.reload(); });
			}
		}
	};
	var alerta = {
		create: {
			success: function() {
				if(alerta_crear && alerta_crear.innerHTML.trim() === "success") {
					var msg = "Se ha creado correctamente el cargo";
					SWEET_ALERT.success(msg);
				}
			},
			error: function() {
				if(alerta_crear && alerta_crear.innerHTML.trim() === "error") {
					var msg = "No se ha podido crear correctamente el cargo. " +
							"Ya existe una cargo con el mismo número de plaza.";
					SWEET_ALERT.error(msg);
				}
			}
		},
		edit: {
			success: function() {
				if(alerta_editar && alerta_editar.innerHTML.trim() === "success") {
					var msg = "Se ha editado correctamente el cargo";
					SWEET_ALERT.success(msg);
				}
			},
			error: function() {
				if(alerta_editar && alerta_editar.innerHTML.trim() === "error") {
					var msg = "No se ha podido editar correctamente. " + 
							"Ya existe una cargo con el mismo número de plaza.";
					SWEET_ALERT.error(msg);
				}
			},
			info: function() {
				if(alerta_editar && alerta_editar.innerHTML.trim() === "info") {
					var msg = "No se ha realizado ningun cambio";
					SWEET_ALERT.info(msg);
				}
			}
		},
		delete: {
			success: function() {
				if(alerta_eliminar && alerta_eliminar.innerHTML.trim() === "success") {
					var msg = "Se ha eliminado correctamente el cargo";
					SWEET_ALERT.info(msg);
				}
			}
		},
		limpiarFormulario: function() {
			if(btn_limpiar) {
				var msg = "¿Está usted seguro de limpiar?, " +
							"si acepta eliminará los datos registrados en el formulario.";
				evento.click.buttonLimpiar(msg);
			}
		},
		eliminarCargo: function() {
				if(btn_eliminar) {
					var msg = "¿Está seguro de eliminar este cargo?";
					evento.click.buttonEliminar(msg);
				}
			}
	};
	// Función de inicialización del selectr (oficina jefe)
	function selectOficinaJefe() {
		select1_element.selector = Plugin.selectr(select1_element.select);
		if(select1_element.selector) {
			var modulo = select1_element.select.dataset.modulo.toLowerCase().trim();
			if(modulo === "crear") {
				SELECTR.cargarOficinas(select1_element.selector, {
					peticion: "lista_oficinas_jefe"
				}, null);
			} else if(modulo === "editar") {
				var value = select1_element.select.dataset.oficinaId;
				SELECTR.cargarOficinas(select1_element.selector, {
					peticion: "lista_oficinas_jefe"
				}, value);
			}
		}
	}
	// Función de inicialización del selectr (suboficina)
	function selectSuboficina() {
		select2_element.selector = Plugin.selectr(select2_element.select);
		if(select2_element.selector) {
			evento.change.selectOficinaJefe();
			if(checkbox.checked) {
				var id = select1_element.select.dataset.oficinaId;
				var value_selected = select2_element.select.dataset.suboficinaId;
				SELECTR.cargarOficinas(select2_element.selector, {
					peticion: "get_suboficinas",
					id: id
				}, value_selected);
			} else
				SELECTR.disableSelect(select2_element);
		}
	}
	// Carga datos, inicializa el datatable para cargo y otras funcionalidades
	function datatableCargo() {
		if(document.body.contains(tableCargo)) {
			// Obtener los datos para la tabla
			Ajax({
				method	: "POST",
				url		: "core/peticionesAjax.php",
				data 	: {
					peticion: "listar_cargos"
				}
			}).initRequest().then(function(result) {
				dt_cargo = Plugin.datatable(tableCargo, JSON.parse(result));
				if(dt_cargo) {
					var columnas = dt_cargo.columns();
					var columnasVisibles = columnas.visible();
					columnas.hide([5,6]);	// ocultar columnas

					var data = {
						datatable: dt_cargo,
						table: tableCargo,
						controlador: "Cargo"
					};
					var datatable = DATATABLE_FUNCTIONS(data, info_dt);
					datatable.main();
				}
			}).catch(function(error) {
				alert(error);
			});
		}
	}
	/* Activa o desactiva el estado de presupuesto mediante un switch */
	function cambiarEstadoPresupuesto() {
		var switchStatus = document.getElementById("switch1");
		if(document.body.contains(switchStatus)) {
			switchStatus.addEventListener("click", function(e) {
				var workerSpan = document.getElementById("worker-cargo");
				var worker = workerSpan.innerHTML.toLowerCase();

				// Solo se puede cambiar el estado de presupuesto si el cargo está VACANTE
				if(worker === "vacante") {
					var label = document.querySelector('.form-check-label[for="switch1"]');
					var id_cargo = this.dataset.idCargo;
					if(this.checked) {
						label.innerHTML = "Con presupuesto";
						ajax_enviar_status_presupuesto(id_cargo, 1);
					} else {
						label.innerHTML = "Sin presupuesto";
						ajax_enviar_status_presupuesto(id_cargo, 0);
					}
				} else {
					e.preventDefault();
					Swal.fire({
					 	title: 'Info',
					 	text: 'No se puede cambiar el estado de presupuesto cuando el cargo está ocupado',
						icon: 'info',
						confirmButtonText: 'Aceptar'
					});
				}
			});
		}
		/**
		 * Cambia el estado del presupuesto mediante una petición ajax
		 * @param{String} id_cargo
		 * @param{Number} new_status
		 */
		function ajax_enviar_status_presupuesto(id_cargo, new_status) {
			Ajax({
				method: "POST",
				url: "core/peticionesAjax.php",
				data: {
					peticion: "cambiar_estado_presupuesto",
					id: id_cargo,
					status: new_status
				}
			}).initRequest();
		}
	}
	// Añade eventos a los botones para exportar el datatable
	function exportableButtons() {
		var pdfButton = document.querySelector("#lista-cargo .pdf-button");
		if(pdfButton) evento.click.exportable.pdfButton(pdfButton);

		var excelButton = document.querySelector("#lista-cargo .excel-button");
		if(excelButton) evento.click.exportable.excelButton(excelButton);

		var printButton = document.querySelector("#lista-cargo .print-button");
		if(printButton) evento.click.exportable.printButton(printButton);
	}
	return {
		init: function() {
			selectOficinaJefe();
			selectSuboficina();
			evento.change.checkbox();
		},
		crear: function() {
			alerta.limpiarFormulario();
		},
		listar: function() {
			datatableCargo();
			exportableButtons();
		},
		mostrar: function() {
			cambiarEstadoPresupuesto();
			alerta.eliminarCargo();
		},
		editar: function() {
			evento.click.closeModal();
		},
		alertas: function() {
			alerta.create.success();
			alerta.create.error();
			alerta.delete.success();
			alerta.edit.success();
			alerta.edit.info();
			alerta.edit.error();
		}
	}
}
function Oficina() {
	// ############## Atributos ##############
	var checkbox = document.querySelector("#form-oficina input[name='check']");
	var select_element = {	// para oficina jefe
		select: document.querySelector("#form-oficina .mySelectr[name='oficina-jefe']"),
		selector: null,
		label: document.querySelector("#form-oficina label[for='oficina-jefe']"),
		value: null // <option selected>
	};
	var dt_oficina;
	var data_table;
	
	var alerta_crear = document.getElementById("alerta-crear-oficina");
	var alerta_eliminar = document.getElementById("alerta-eliminar-oficina");
	var alerta_editar = document.getElementById("alerta-editar-oficina");

	var btn_limpiar = document.querySelector("#crear-oficina button.btn-limpiar");
	var btn_eliminar = document.querySelector("#mostrar-oficina button.btn-eliminar");
	/**
	 * Orden de items del datatable
	 * 0 => numero de orden
	 * 2 => link
	 */
	var info_dt = {
		index: [0, 2],
		class: ["num-column", "link-column"]
	};
	// ############## End of atributos ##############

	var listener = {
		change: {
			// Habilita/deshabilita el select oficina_jefe
			toggleOficinaJefe: function(event){
				if(event.target.checked) {
					SELECTR.enableSelect(select_element);
					SELECTR.cargarOficinas(select_element.selector, 
						{peticion: "lista_oficinas_jefe"}, null);
				} else
					SELECTR.disableSelect(select_element);
			}
		}
	};
	var evento = {
		change: {
			checkbox: function() {
				var crear_oficina = document.querySelector('#crear-oficina');
				var modal_editar_oficina = document.querySelector('#modal-editar-oficina');
				if(crear_oficina || modal_editar_oficina)
					checkbox.addEventListener("change", listener.change.toggleOficinaJefe);
			}
		},
		click: {
			buttonLimpiar: function(msg) {
				btn_limpiar.addEventListener("click", function() {
					SWEET_ALERT.resetearFormulario(msg);
				});
			},
			buttonEliminar: function(msg) {
				btn_eliminar.addEventListener("click", function() {
					var url = "?controller=Oficina&action=eliminar&id=";
					var id = this.value;
					SWEET_ALERT.eliminar(msg, url, id);
				});
			},
			exportable: {
				pdfButton: function(pdf_button) {
					pdf_button.addEventListener("click", function() {
						data_table = Object.assign({}, EXPORTABLE.organizarData(dt_oficina));
						EXPORTABLE.exportToPDF(data_table, "pdfcommand");
					});
				},
				excelButton: function(excel_button) {
					excel_button.addEventListener("click", function() {
						data_table = Object.assign({}, EXPORTABLE.organizarData(dt_oficina));
						EXPORTABLE.exportToExcel(data_table.body);
					});	
				},
				printButton: function(print_button) {
					print_button.addEventListener("click", function() {
						data_table = Object.assign({}, EXPORTABLE.organizarData(dt_oficina));
						EXPORTABLE.exportToPdf(data_table, "printcommand");
					});
				}
			},
			// Reinicia los datos iniciales al cerrar un modal
			closeModal: function() {
				var close_modal = document.querySelector("#modal-editar-oficina button.btn-close");
				if(close_modal) {
					close_modal.addEventListener("click", ()=>{ 
						location.reload();
					});
				}
			}
		}
	};
	// Sweet Alert 
	var alerta = {
		create: {
			success: function() {
				if(alerta_crear && alerta_crear.innerHTML.trim() === "success") {
					var msg = "Se ha creado correctamente la oficina";
					SWEET_ALERT.success(msg);
				}
			},
			error: function() {
				if(alerta_crear && alerta_crear.innerHTML.trim() === "error") {
					var msg = "No se ha podido crear correctamente una oficina. " +
							"Ya existe una oficina con el mismo nombre.";
					SWEET_ALERT.error(msg);
				}
			}
		},
		edit: {
			success: function() {
				if(alerta_editar && alerta_editar.innerHTML.trim() === "success") {
					var msg = "Se ha editado correctamente la oficina";
					SWEET_ALERT.success(msg);
				}
			},
			error: function() {
				if(alerta_editar && alerta_editar.innerHTML.trim() === "error") {
					var msg = "No se ha podido editar correctamente. " + 
							"Ya existe una oficina con el mismo nombre";
					SWEET_ALERT.error(msg);
				}
			},
			info: function() {
				if(alerta_editar && alerta_editar.innerHTML.trim() === "info") {
					var msg = "No se ha realizado ningun cambio";
					SWEET_ALERT.info(msg);
				}
			}
		},
		delete: {
			success: function() {
				if(alerta_eliminar && alerta_eliminar.innerHTML.trim() === "success") {
					var msg = "Se ha eliminado correctamente la oficina";
					SWEET_ALERT.success(msg);
				}
			}
		},
		limpiarFormulario: function() {
			if(btn_limpiar) {
				var msg = "¿Está usted seguro de limpiar?, " +
							"si acepta eliminará los datos registrados en el formulario.";
				evento.click.buttonLimpiar(msg);
			}
		},
		eliminarOficina: function() {
			if(btn_eliminar) {
				var msg = "¿Está seguro de eliminar está oficina?";
				evento.click.buttonEliminar(msg);
			}
		}
	};
	// Elimina las cookies o añade, después de ser redireccionado por un controlador de PHP
	function refactorizarCookies() {
		if(alerta_crear)	// FLAG
			sessionStorage.removeItem("submenu-item");
		if(alerta_eliminar)
			sessionStorage.setItem("submenu-item", 1);
		// location.reload();
	}

	// Función de inicialización para el selectr(oficina jefe) y como deben desplegarse
	function selectrOficinaJefe() {	
		select_element.selector = Plugin.selectr(select_element.select);
		if(select_element.selector) {
			if(checkbox.checked) {
				select_element.value = select_element.select.dataset.oficinaJefe;
				SELECTR.enableSelect(select_element);
				SELECTR.cargarOficinas(select_element.selector, 
					{peticion: "lista_oficinas_jefe"}, select_element.value);
			} else
				SELECTR.disableSelect(select_element);
		}
	}
	// Datatable oficina
	function datatableOficina() {
		var table_oficina = document.getElementById('dt-oficina');
		if(document.body.contains(table_oficina)) {
			// Obtener los datos para la tabla
			Ajax({
				method	: "POST",
				url		: "core/peticionesAjax.php",
				data 	: { 
					peticion: "lista_oficinas"
				}
			}).initRequest().then(function(result) {
				dt_oficina = Plugin.datatable(table_oficina, JSON.parse(result));
				if(dt_oficina !== null ) {
					var data = {
						table: table_oficina,
						datatable: dt_oficina,
						controlador: "Oficina"
					};
					var datatable = DATATABLE_FUNCTIONS(data, info_dt);
					datatable.main();
				}
			}).catch(function(error) {
				alert(error);
			});
		}
	}
	// Añade eventos a los botones para exportar el datatable
	function exportableButtons() {
		var pdfButton = document.querySelector("#lista-oficina .pdf-button");
		if(pdfButton) evento.click.exportable.pdfButton(pdfButton);

		var excelButton = document.querySelector("#lista-oficina .excel-button");
		if(excelButton) evento.click.exportable.excelButton(excelButton);

		var printButton = document.querySelector("#lista-oficina .print-button");
		if(printButton) evento.click.exportable.printButton(printButton);
	}
	return {
		init: function() {
			selectrOficinaJefe();
			evento.change.checkbox();
		},
		crear: function() {
			alerta.limpiarFormulario();
		},
		listar: function() {
			datatableOficina();
			exportableButtons();
		},
		mostrar: function() {
			alerta.eliminarOficina();
		},
		editar: function() {
			evento.click.closeModal();
		},
		alertas: function() {
			refactorizarCookies();

			alerta.create.success();
			alerta.create.error();
			alerta.delete.success();
			alerta.edit.success();
			alerta.edit.error();
			alerta.edit.info();
		}
	}
}

// Funcionalidades generales del datatable
function DATATABLE_FUNCTIONS(data, info_dt) {
	var table = data.table;
	var datatable = data.datatable;
	var columnas = datatable.columns();
	var columnasVisibles = columnas.visible();	// array
	var headingList = datatable.headings;		// HTMLCollection
	var checkboxContainer = document.getElementById("checkbox-datatable-container");
	var controlador = data.controlador;
	var thead_html = "thead > tr > th:nth-child(";
	var td_html = "tbody > tr > td:nth-child(";

	var listener = {
		checkbox: {
			// Muestra-oculta las columnas dependiendo del marquer checkbox	
			toggleColumn: function() {
				var column_selected = parseInt(this.value);
				if(this.checked)
					columnas.show([column_selected]);
				else
					columnas.hide([column_selected]);
				// -----
				doesSomething();
			}
		}
	};
	var evento = {
		checkbox: function(input) {
			input.addEventListener("change", listener.checkbox.toggleColumn);
		},
		datatable: function() {
			datatable.on('datatable.init', ()=> doesSomething() );
			datatable.on('datatable.perpage', ()=> doesSomething() );
			datatable.on('datatable.page', ()=> doesSomething() );
			datatable.on('datatable.sort', ()=> doesSomething() );
			datatable.on('datatable.search', ()=> doesSomething() );
		}
	};
	function doesSomething() {
		redireccionar();
		specialColumns();	
	}
	// Añade un enlace de redirección al <td> de la columna LINK
	function redireccionar() {	// change the name, i don't like
		var linkList = table.querySelectorAll("i.dt-link");
		for(var link of linkList) {
			link.addEventListener("click", function(e) {
				var id = this.dataset.id;
				// Desactiva el submenu-item activado
				sessionStorage.removeItem("submenu-item");
				location.href = "?controller="+controlador+"&action=mostrar&id="+id;
			});
		}
	}
	// Oculta o muestra columnas mediante checkboxes
	function mostrarOcultarColumnas() {
		var checkboxInputList = checkboxContainer.querySelectorAll("input.form-check-input");
		for(var input of checkboxInputList)
			evento.checkbox(input);
	}
	// Crea dinámicamente los checkboxes en HTML de la visibilidad de columnas
	function createCheckboxes() {
		var html_element = {
			div: function() {
				var contenedor = document.createElement("div");
				var atributo_clase = document.createAttribute("class");
				atributo_clase.value = "form-check form-check-inline";
				contenedor.setAttributeNode(atributo_clase);
				return contenedor;
			},
			input: function(valor) {
				var input = document.createElement("input");
				var atributo = {
					class: document.createAttribute("class"),
					type: document.createAttribute("type"),
					value: document.createAttribute("value")
				};
				atributo.class.value = "form-check-input";
				atributo.type.value = "checkbox";
				atributo.value.value = valor;

				input.setAttributeNode(atributo.class);
				input.setAttributeNode(atributo.type);
				input.setAttributeNode(atributo.value);
				return input;
			},
			label: function(text_content) {
				var label = document.createElement("label");
				label.innerHTML = text_content;
				return label;
			}
		};
		for(var column=0; column<columnasVisibles.length; column++) {
			var new_checkbox = html_element.div();
			var new_input = html_element.input(column);
			var new_label = html_element.label(headingList[column].textContent);
			new_input.checked = columnasVisibles[column];
			checkboxContainer.appendChild(new_checkbox);
			new_checkbox.appendChild(new_input);
			new_checkbox.appendChild(new_label);
		}
	}
	// -----
	function specialColumns() {
		columnasVisibles = columnas.visible(); 
	
		for(var i=0; i<info_dt.index.length; i++) {
			var index = info_dt.index[i];
			if(columnasVisibles[index] === true) {
				// Contar columnas ocultas
				var columnas_ocultas = 0;
				for(var x=0; x<index; x++) {
					if(columnasVisibles[x] === false)
						columnas_ocultas++;
				}

				var nth_child = (index-columnas_ocultas)+1;
				var th = table.querySelector(thead_html+nth_child+")");
				th.classList.add(info_dt.class[i]);
				var tdList = table.querySelectorAll(td_html+nth_child+")");
				for(var td of tdList) {
					td.classList.add(info_dt.class[i]);
				}
			}
		}
	}
	return {
		main: function() {
			evento.datatable();
			createCheckboxes();
			mostrarOcultarColumnas();

			// Ordenar siempre por #
			columnas.sort(1);
		}
	}
} 
});

// Funcionalidades generales de selectr
var SELECTR = {
	/** 
	 * Desactiva el select 
	 * @param{Object} select_element
	 */
	disableSelect: function(select_element) {
		var parentContainer = select_element.select.parentElement;
		var selectContainer = parentContainer.querySelector('.selectr-selected');

		select_element.selector.removeAll();
		select_element.selector.disable();
		select_element.select.removeAttribute('required');
		selectContainer.classList.remove('selectr-invalid');
	},
	/** 
	 * Habilita el select
	 * @param{Object} select_element
	 */
	enableSelect: function(select_element) {
		var parentContainer = select_element.select.parentElement;
		var selectContainer = parentContainer.querySelector('.selectr-selected');

		select_element.selector.enable();
		select_element.select.setAttribute('required','');
		selectContainer.classList.add('selectr-invalid');
	},
	/**
	 * Carga oficinas en el Select desde AJAX
	 * @param{Selector} selector
	 * @param{Object} peticionAjax
	 * @param{String} selectedValue
	 */
	cargarOficinas: function(selector, ajax_data, selected_value) {
		Ajax({
			method 	: "POST",
			url 	: "core/peticionesAjax.php",
			data 	: Object.assign({}, ajax_data)
		}).initRequest().then(function(result) {
			var data = JSON.parse(result);
			data.forEach((oficina) => {
				// Si un <option> es selected 
				if(selected_value !== null) {
					if(selected_value === oficina.value) {
						selector.add({
							value: oficina.value,
							text: oficina.name,
							selected: true
						});
					} else {
						selector.add({
							value: oficina.value,
							text: oficina.name
						});	
					}
				} else {
					selector.add({
						value: oficina.value,
						text: oficina.name
					});
				}
			});
		}).catch(function(error) {
			alert(error);
			selector.disable();
		});
	}
}

// Funcionalidades generales de alertas
const Toast = Swal.mixin({
	toast: true,
	position: "bottom-right",
	timer: 4000,
	timerProgressBar: true,
	didOpen: (toast) => {
	    toast.addEventListener('mouseenter', Swal.stopTimer)
	    toast.addEventListener('mouseleave', Swal.resumeTimer)
  	}
});
var SWEET_ALERT = {
	success: function(msg) {
		Toast.fire({
			title: "Success",
			text: msg,
			icon: "success"
		});
	},
	error: function(msg) {
		Toast.fire({
		 	title: "Error",
		 	text: msg,
			icon: "error"
		});
	},
	info: function(msg) {
		Toast.fire({
		 	title: "Info",
		 	text: msg,
			icon: "info"
		});
	},
	resetearFormulario: function(msg) {
		Swal.fire({
			title: "Reset form",
			text: msg,
			icon: "question",
			confirmButtonText: "Aceptar",
			cancelButtonText: "Cancelar",
			showCancelButton: true
		}).then(function(result) {
			if(result.isConfirmed)
				location.reload();
		});
	},
	/**
	 * Eliminar una (oficina, cargo o trabajador mediante ID)
	 * @param{String} msg
	 * @param{String} url
	 * @param{Int} id 
	 */
	eliminar: function(msg, url, id) {
		Swal.fire({
			title: "Warning",
			text: msg,
			icon: "warning",
			confirmButtonText: "Aceptar",
			cancelButtonText: "Cancelar",
			showCancelButton: true
		}).then(function(result) {
			if(result.isConfirmed) {
				// Action delete on php
				location.href = url+id;
			}
		});
	}
};

// Funcionalidades generales para exportar datos del datatable
var EXPORTABLE = {
	/*
	 * Exporta a PDF o abre una nueva pestaña para imprimir
	 * @param{Object} data_table
	 * @param{String} command -Tipo de accion (pdf o print)
	 */
	exportToPdf: function(data_table, command) {
		window.jsPDF = window.jspdf.jsPDF;
		var doc = new jsPDF();
		var filename = "reporte.pdf";	// Nombre del archivo
		doc.autoTable({
			head: [data_table.head], 
			body: data_table.body,
			theme: "grid"
		});

		if(command === "printcommand")
			doc.output("dataurlnewwindow", filename);	// open a new window to print
		else if(command === "pdfcommand")
			doc.save(filename);	// save a pdf file
	},
	/*
	 * Exporta a Excel
	 * @param{Array} body_data
	 */
	exportToExcel: function(body_data) {
		var filename = "reporte.xlsx";	// Nombre del archivo
		var ws_name = "Hoja 1";			// Nombre del libro
		var wb = XLSX.utils.book_new();	
		var ws = XLSX.utils.aoa_to_sheet(body_data);
		XLSX.utils.book_append_sheet(wb, ws, ws_name);
		XLSX.writeFile(wb, filename);
	},
	/*
	 * Organiza los datos...
	 * @param{Datatable plugin} datatable
	 * @return{Object} data -Objeto de arrays
	 */
	organizarData: function(datatable) {
		var data = {
			body: [],
			head: []
		};

		var dataRows = datatable.activeRows;
		var headRow = datatable.headings;
		var visibleColumns = datatable.columns().visible();

		// Añade todos los datos del datatable en un array
		for(var tr of dataRows) {
			var td = tr.querySelectorAll("td");
			var row = [];
			for(var i=0; i<td.length; i++)	// except the last
				row.push(td[i].innerText);
			data.body.push(row);
		}
		// Añade solo los datos de búsqueda en un array
		if(datatable.searching) {
			var body_search_data = [];
			var indexSearchData = datatable.searchData;	// array
			for(var i=0; i<indexSearchData.length-1; i++) {
				var index = indexSearchData[i];
				body_search_data.push(data.body[index]);
			}
			data.body = [];
			data.body = Array.from(body_search_data);
		}
		// Añade los datos de cabecera del datatable en un array dependiendo de si las columnas están ocultas o no
		for(var i=0; i<headRow.length-1; i++) {
			if(visibleColumns[i] === true)
				data.head.push(headRow[i].innerText);
		}
		return data;
	}
}