$(document).ready(function() {
	$('.js-toggle').click(function(e){
		e.stopPropagation();
		e.preventDefault();

		// Self
		var self = $(this);
		var toggleClass = (self.attr('data-class') ? self.attr('data-class') : 'is-open');

		// Target
		var target = (self.attr('data-target') ? $(self.attr('data-target')) : self);
		var toggleGroup = (target.attr('data-group') ? target.attr('data-group') : null);

		// blurTarget (if any)
		var blurTarget = (self.attr('data-blur') ? $(self.attr('data-blur')) : null);
		var blurToggleClass = (target.attr('data-blurClass') ? target.attr('data-blurClass') : 'is-blur');

		// If class is set, remove it
		if (target.hasClass(toggleClass)) {
			target.removeClass(toggleClass);
		} else {
			// Remove class from data groups if any and add it to target
			$('[data-group="'+toggleGroup+'"].'+toggleClass).removeClass(toggleClass);
			target.addClass(toggleClass);

			// If blurTarget is set, add blur class and click handler
			if (blurTarget) {
				blurTarget.addClass(blurToggleClass);

				// Do not trigger blurTarget click when clicking inside target
				target.click(function(e){ e.stopPropagation(); });

				// If blurTarget is clicked, remove target and
				// blurTarget classes and remove click handler
				blurTarget.click(function(e) {
					e.stopPropagation();
					e.preventDefault();

					// Remove classes from targets
					target.removeClass(toggleClass);
					blurTarget.removeClass(blurToggleClass);

					// Remove click event handlers
					blurTarget.off('click');
					target.off('click');
				});
			}
		}
	});
});