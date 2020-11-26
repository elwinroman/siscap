
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
/////////////////////////////////////////////////////////////////////
var Plugin = {
	/**
	 * Crea un nuevo selector de la clase Selectr
	 * @param{HTMLElement} element
	 * @return[newSelectrObject]
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
	datatables: function() {
		//code here
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
	(function construct() {
		if(newConfig.method)
			config.method = newConfig.method,
		config.url = newConfig.url;
		if(newConfig.data) {
			config.data = serializeData(newConfig.data);
		}
	})();
	console.log("config.data = " + config.data);
	/**
	 * Asigna el contenido devuelto de la petición en variables del Objeto Promise 
	 */
	function checkRequest(resolve, reject) {
		if(xhttp.readyState == 4) {
		    if(xhttp.status == 200) {
		    	if(xhttp.responseText !== "error")
		    		resolve(xhttp.responseText);
		    	else
		    		reject("a query error has ocurred");
		    }
		    else
		    	reject(xhttp.statusText);
		}
	}
	/**
	 * Obtiene el número de propiedades de un objeto
	 * @param{Object} object
	 * @return[Integer] length
	 */
	function getObjectLength(object) {
		var length = 0;
		for(var prop in object)
			length++;
		return length;
	}
	/**
	 * Serializa un Objeto de datos para enviarlos a un servidor (PHP)
	 * Ejemplo: "nombre=elwin&apellido=roman&edad=23" etc.
	 * @return{string} dataSerialized
	 */
	function serializeData(dataObject) {
		var dataSerialized = '';
		var count = 0;
		for(var prop in dataObject) {
			count++;
			dataSerialized += (prop+'='+dataObject[prop]);
			if(count < getObjectLength(dataObject))
				dataSerialized += '&';
		}
		return dataSerialized;
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