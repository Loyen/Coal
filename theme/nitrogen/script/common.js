if (Element.prototype.hasClass == undefined) {
	Element.prototype.hasClass = function (className) {
		return new RegExp(' ' + className + ' ').test(' ' + this.className + ' ');
	};
}

if (Element.prototype.addClass == undefined) {
	Element.prototype.addClass = function (className) {
		if (!this.hasClass(className)) {
			this.className += ' ' + className;
		}
	};
}

if (Element.prototype.removeClass == undefined) {
	Element.prototype.removeClass = function (className) {
		var newClass = ' ' + this.className.replace(/[\t\r\n]/g, ' ') + ' '
		if (this.hasClass(className)) {
			while (newClass.indexOf( ' ' + className + ' ') >= 0) {
				newClass = newClass.replace(' ' + className + ' ', ' ');
			}
			this.className = newClass.replace(/^\s+|\s+$/g, ' ');
		}
	};
}

if (Element.prototype.toggleClass == undefined) {
	Element.prototype.toggleClass = function (className) {
		var newClass = ' ' + this.className.replace(/[\t\r\n]/g, " ") + ' ';
		if (this.hasClass(className)) {
			while (newClass.indexOf(" " + className + " ") >= 0) {
				newClass = newClass.replace(" " + className + " ", " ");
			}
			this.className = newClass.replace(/^\s+|\s+$/g, ' ');
		} else {
			this.className += ' ' + className;
		}
	};
}
