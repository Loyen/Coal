Coal.behaviors.toggle = function(el) {
	var click = function(item, e) {
		e.stopPropagation();
		e.preventDefault();

		var toggleClass = (item.getAttribute('data-class') ? item.getAttribute('data-class') : 'is-open');

		// Target
		var target = (item.getAttribute('data-target') ? document.querySelector(item.getAttribute('data-target')) : item);
		var toggleGroup = (item.getAttribute('data-group') ? item.getAttribute('data-group') : null);

		// Blur target (if any)
		var blurTarget = (item.getAttribute('data-blur') ? document.querySelector(item.getAttribute('data-blur')) : null);
		var blurToggleClass = (item.getAttribute('data-blurClass') ? item.getAttribute('data-blurClass') : 'is-blur');

		if (target.hasClass(toggleClass)) {
			target.removeClass(toggleClass);
		} else {
			if (toggleGroup) {
				var toggleGroupItems = el.querySelectorAll('[data-group='+toggleGroup+'].'+toggleClass);
				for (i=0; i < toggleGroupItems.length; i++) {
					var toggleGroupItem = toggleGroupItems[i];
					toggleGroupItem.removeClass(toggleClass);
				}
			}

			target.addClass(toggleClass);

			if (blurTarget) {
				blurTarget.addClass(blurToggleClass);

				// Do not trigger blurTarget click when clicking on target
				var onTargetClick = function(e) {
					e.stopPropagation();
				};

				target.addEventListener('mouseup', onTargetClick);

				var onBlur = function(e) {
					e.stopPropagation();
					e.preventDefault();

					target.removeClass(toggleClass);
					blurTarget.removeClass(blurToggleClass);

					target.removeEventListener('mouseup', onTargetClick);
					blurTarget.removeEventListener('mouseup', onBlur);
				};

				blurTarget.addEventListener('mouseup', onBlur);
			}
		}
	};

	var items = el.querySelectorAll('.js-toggle');

	for (var i=0; i < items.length; i++) {
		var item = items[i];

		if (item.hasClass('js-toggle-init')) continue;
		item.addClass('js-toggle-init');

		item.addEventListener('mouseup', function(e) {
			click(this, e);
		});
	}
}; // toggle
