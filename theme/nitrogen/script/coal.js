// Init Coal
var Coal = function(){};

Coal.browserSupport = function(){
	var htmlElement = document.documentElement;

	htmlElement.addClass('js');

	if (htmlElement.style.hasOwnProperty('transform')) {
		htmlElement.addClass('css-transform');
	}

	if (htmlElement.style.hasOwnProperty('transition')) {
		htmlElement.addClass('css-transition');
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
	Coal.attachBehaviors(document.body);
}; // Coal.init

document.addEventListener("DOMContentLoaded", function(e) {
	Coal.init();
});

