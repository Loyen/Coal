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

		if (target.classList.contains(toggleClass)) {
			target.classList.remove(toggleClass);
		} else {
			if (toggleGroup) {
				var toggleGroupItems = el.querySelectorAll('[data-group='+toggleGroup+'].'+toggleClass);
				for (i=0; i < toggleGroupItems.length; i++) {
					var toggleGroupItem = toggleGroupItems[i];
					toggleGroupItem.classList.remove(toggleClass);
				}
			}

			target.classList.add(toggleClass);

			if (blurTarget) {
				blurTarget.classList.add(blurToggleClass);

				// Do not trigger blurTarget click when clicking on target
				var onTargetClick = function(e) {
					e.stopPropagation();
				};

				target.addEventListener('mouseup', onTargetClick);

				var onBlur = function(e) {
					e.stopPropagation();
					e.preventDefault();

					target.classList.remove(toggleClass);
					blurTarget.classList.remove(blurToggleClass);

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

		if (item.classList.contains('js-toggle-init')) continue;
		item.classList.add('js-toggle-init');

		item.addEventListener('mouseup', function(e) {
			click(this, e);
		});
	}
}; // toggle
