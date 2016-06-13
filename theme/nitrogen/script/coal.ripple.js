Coal.behaviors.ripple = function(el) {
	var classes = {
		'container': 'ripple',
		'ripple': 'ripple-wave',
		'rippleActive': 'active',
		'rippleInactive': 'inactive'
	};

	var rippleContainerElement = document.createElement('div');
	rippleContainerElement.setAttribute('class', classes.container);

	var rippleItemElement = document.createElement('div');
	rippleItemElement.setAttribute('class', classes.ripple);


	var click = function(item, e) {
		var rippleContainer = item.querySelector('.'+classes.container);
		if (!rippleContainer) {
			rippleContainer = rippleContainerElement.cloneNode();
			item.appendChild(rippleContainer);
		}

		var rippleItem = rippleItemElement.cloneNode();

		var rippleContainerWidth = rippleContainer.offsetWidth;
		var rippleContainerHeight = rippleContainer.offsetHeight;

		var clickX = e.offsetX;
		var clickY = e.offsetY;

		var rippleSize = 0;

		if (rippleContainerWidth > rippleContainerHeight) {
			rippleSize = rippleContainerWidth;
		} else {
			rippleSize = rippleContainerHeight;
		}

		rippleItem.style.width = rippleSize+'px';
		rippleItem.style.height = rippleSize+'px';

		rippleItem.style.left = clickX-(rippleSize/2)+'px';
		rippleItem.style.top = clickY-(rippleSize/2)+'px';

		setTimeout(function(){rippleItem.classList.add(classes.rippleActive);}, 1);

		rippleContainer.appendChild(rippleItem);
	};

	var release = function(item, e) {
		var rippleItems = item.querySelectorAll('.'+classes.ripple);
		for (var i=0; i < rippleItems.length; i++) {
			var rippleItem = rippleItems[i];

			if (rippleItem.classList.contains(classes.rippleInactive)) continue;

			rippleItem.classList.remove(classes.rippleActive);
			rippleItem.classList.add(classes.rippleInactive);

			setTimeout(function(){
				if (!rippleItem.parentElement) return;
				rippleItem.parentElement.removeChild(rippleItem);
			}, 1000);
		}
	};

	var items = el.querySelectorAll('.js-ripple');
	for (var i=0; i < items.length; i++) {
		var item = items[i];

		if (item.classList.contains('js-ripple-init')) continue;
		item.classList.add('js-ripple-init');

		var clickEvent = function(e) {
			click(this, e);
		};

		var releaseEvent = function(e) {
			release(this, e);
		};

		item.addEventListener('mousedown', clickEvent);
		item.addEventListener('mouseleave', releaseEvent);
		item.addEventListener('mouseup', releaseEvent);
	}
}; // ripple
