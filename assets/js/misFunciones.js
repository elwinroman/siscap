// document.addEventListener('DOMContentLoaded', function() {
	"use strict";
	const SIZE_DEVICE = {
		small		: 576,	// SmallDevices
		extraSmall 	: 400	// ExtraSmallDevices
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
// });