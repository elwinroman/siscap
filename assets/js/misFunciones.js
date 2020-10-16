// document.addEventListener('DOMContentLoaded', function() {
	"use strict";
	const SizeDevice = {
		small		: 576,	// SmallDevices
		extraSmall 	: 400	// ExtraSmallDevices
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