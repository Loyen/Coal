// Init Coal
var Coal = function(){};

Coal.browserSupport = function(){
	var htmlElement = document.documentElement;

	htmlElement.classList.add('js');

	if (htmlElement.style.hasOwnProperty('transform')) {
		htmlElement.classList.add('css-transform');
	}

	if (htmlElement.style.hasOwnProperty('transition')) {
		htmlElement.classList.add('css-transition');
	}
};

Coal.behaviors = {};
Coal.attachBehaviors = function(el){
	for (var func in Coal.behaviors){
		if (Coal.behaviors.hasOwnProperty(func)){
			var obj = Coal.behaviors[func];
			obj(el);
		}
	};
}; // Coal.attachBehaviors

Coal.init = function(){
	Coal.browserSupport();
	Coal.attachBehaviors(document.documentElement);
}; // Coal.init

document.addEventListener("DOMContentLoaded", function(e) {
	Coal.init();
});

