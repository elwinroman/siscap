
"use strict";
const SIZE_DEVICE = {
	extraSmall 	: 400,	// ExtraSmall
	small		: 576,	// Small
	medium		: 768	// Medium
};
const DEPARTAMENTO_PUNO = {
	"Azángaro":["Azángaro","Achaya","Arapa","Asillo","Caminaca","Chupa","José Domingo Choquehuanca","Muñani","Potoni","Samán","San Antón","San José","San Juan de Salinas","Santiago de Pupuja","Tirapata"],
	"Carabaya":["Ajoyani","Ayapata","Coasa","Corani","Crucero","Ituata","Macusani","Ollachea","San Gabán","Usicayos"],
	"Chucuito":["Juli","Desaguadero","Huacullani","Kelluyo","Pisacoma","Pomata","Zepita"],
	"El Collao":["Copaso","Conduriri","Ilave","Pilcuyo","Santa Rosa"],
	"Huancané":["Cojata","Huancané","Huatasani","Inchupalla","Pusi","Rosaspata","Taraco","Vilque Chico"],
	"Lampa":["Cabanilla","Calapuja","Lampa","Nicasio","Ocuviri","Palca","Paratía","Pucará","Santa Lucía","Vilavila"],
	"Melgar":["Antauta","Ayaviri","Cupi","Llalli","Macari","Ñuñoa","Orurillo","Santa Rosa","Umachiri"],
	"Moho":["Conima","Huayrapata","Moho","Tilali"],
	"Puno":["Acora","Amantani","Atuncolla","Capachica","Chucuito","Coata","Huata","Mañazo","Paucarcolla","Pichacani","Platería","Puno","San Antonio","Tiquillaca","Vilque"],
	"Sandia":["Alto Inambari","Cuyocuyo","Limbani","Patambuco","Quiaca","Phara","San Pedro de Putinapunco","Sandia","Yanahuaya","San Juan del Oro"],
	"San Antonio de Putina":["Ananea","Pedro Vilca Apaza","Putina","Quilcapuncu","Sina"],
	"San Román":["Cabana","Cabanillas","Caracoto","Juliaca","San Miguel"],
	"Yunguyo":["Yunguyo","Anapia","Copani","Cuturapi","Ollaraya","Tinicachi","Unicachi"]
};

/////////////////////////////////////////////////////////////////////
var Animation = {
	/**
     * Efecto SlideUp
     * @param {DOMElement} element
     * @param {Number} duration
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
     * @param {DOMElement} elemento
     * @param {Number} duration
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
/////////////////////////////////////////////////////////////////////
var Plugin = {
	/**
	 * Crea un nuevo selector del plugin 'selectr'
	 * @param {DOMElement} element
	 * @return {Object Selectr | null} newSelectr
	 */
	selectr: function(element) {
		if(document.body.contains(element)) {
			var newSelectr = new Selectr(element, {
				searchable: false,
				placeholder: 'Seleccione...',
				messages: {
					noResults: 'No resultados',
					noOptions: 'No options'
				}
			});
			return newSelectr;
		}
		return null;
	},

	/**
	 * Crea un nuevo datatable del plugin 'Vanilla-dataTable'
	 * @param {DOMElement} element
	 * @param {Array Objects} data
	 * @return {Object dataTable} newDatatable
	 */
	datatable: function(element, data) {
		if(document.body.contains(element)) {
			var headingArray = Object.keys(data[0]);
			var lastHeading = headingArray.length-1;

			var newDatatable = new DataTable(element, {
				labels: {
					placeholder: "Buscar...",
					perPage: "Mostrar {select} registros",
					noRows: "No hay datos para mostrar",
					info: "Mostrando registros del {start} al {end} de un total de {rows} registros"
				},
				data: { 
					"headings": headingArray,
					"data": helper_function.arrayDataParse(data)
				},
				perPageSelect: [10, 25, 50, 100],
				columns: [
					{ select: lastHeading, sortable: false }
				]
			});

			return newDatatable;
		}
		return null;
	}
}
////////////////////////////////////////////////////////////////////////////
function Ajax(newConfig) {
	var xhttp = new XMLHttpRequest();
	var config = {
		method	: "GET",	// optional
		url 	: '',		// required
		data 	: ''		// optional
	};
	// Constructor
	(function construct() {
		if(newConfig.method)
			config.method = newConfig.method,
		config.url = newConfig.url;
		if(newConfig.data) {
			config.data = helper_function.serializeData(newConfig.data);
		}
	})();
	// Asigna el contenido devuelto de la petición en variables del Objeto Promise
	function checkRequest(resolve, reject) {
		if(xhttp.readyState == 4) {
		    if(xhttp.status == 200) {
		    	if(xhttp.responseText === "error")
		    		reject("a query error has ocurred");
		    	else if(xhttp.responseText === "empty")
		    		reject("no hay datos disponibles");
		    	else
		    		resolve(xhttp.responseText);
		    }
		    else
		    	reject(xhttp.statusText);
		}
	}
	return {
		initRequest: function() {
			return new Promise((resolve, reject) => {
				xhttp.onreadystatechange = () => { checkRequest(resolve, reject); };
				if(config.method === "GET") {
					xhttp.open(config.method, config.url + "?" + config.data, true);
					xhttp.send();
				} else if(config.method === "POST") {
					xhttp.open(config.method, config.url, true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send(config.data);
				}
			});
		}
	}
}
// Funciones de ayuda
var helper_function = {
	/**
	 * Neutralizador de acentos exceptuando (ñÑ accents) [para cualquier lenguaje]
	 * @param {String} data
	 * @return {String} data
	 */
	removeAccents: function(data) {
		if(data.normalize) {
	        return data
	        	.normalize('NFD')
	        	.replace(/([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi, '$1').
	        	normalize();
	    	}
    	return data;
	},
	/**
	 * Serializa un Objeto de datos para enviarlos a un servidor (PHP)
	 * Ejemplo: "data1=value1&data2=value2&data3=value3" etc.
	 * @param {Object} dataObject
	 * @return {string} dataSerialized
	 */
	serializeData: function(dataObject) {
		var dataSerialized = '';
		var count = 0;
		for(var prop in dataObject) {
			count++;
			dataSerialized += (prop+'='+dataObject[prop]);
			if(count < helper_function.getObjectLength(dataObject))
				dataSerialized += '&';
		}
		return dataSerialized;
	},
	/**
	 * Convierte un array de objetos a un array de arrays para el tbody-datatable
	 * @param {Object} data
	 * @return {Array} newData
	 */
	arrayDataParse: function(data) {
		var newData = [];
		for(var i=0; i<data.length; i++) {
		    newData[i] = [];
		    for (var p in data[i]) {
		        if(data[i].hasOwnProperty(p))
		            newData[i].push(data[i][p]);
		    }
		}
		return newData;
	},
	/**
	 * Obtiene el número de propiedades de un objeto
	 * @param {Object} object
	 * @return {Integer} length
	 */
	getObjectLength: function(object) {
		var length = 0;
		for(var prop in object)
			length++;
		return length;
	},
	/** 
	 * Remueve nombres de clases a una lista de elementos 
	 * @param{HTMLCollection} elementList 	=> Lista de nodos
	 * @param{string} nameClass 			=> Nombre de clase
	 */
	myRemoveClass: function(elementList, nameClass) {
		for(var element of elementList)
			element.classList.remove(nameClass);
	},
	/** 
	 * Añade nombres de clases a una lista de elementos 
	 * @param {HTMLCollection} elementList => Lista de nodos
	 * @param {string} nameClass		   => Nombre de clase
	 */
	myAddClass: function(elementList, nameClass) {
		for(var element of elementList)
			element.classList.add(nameClass);
	}
}

