<div class="navigation navigation--sidebar raise-5">
	<div class="navigation-item">
		<a class="navigation-link" href="<?=url('home');?>"><span class="icon icon--home"></span> Home</a>
	</div>

	<div class="navigation-itemSeparator"></div>

	<div class="navigation-item">
		<a class="navigation-link" href="javascript:void(0);"><span class="icon icon--post"></span> Posts</a>
	</div>
	<div class="navigation-item">
		<a class="navigation-link" href="javascript:void(0);"><span class="icon icon--page"></span> Pages</a>
	</div>

	<div class="navigation-itemSeparator"></div>

	<div class="navigation-item">
		<a class="navigation-link" href="javascript:void(0);"><span class="icon icon--settings"></span> Settings</a>
	</div>
	<div class="navigation-item">
		<?php if (user::anonymous()) { ?>
			<a class="navigation-link" href="javascript:void(0);"><span class="icon icon--login"></span> Login</a>
		<?php } else { ?>
			<a class="navigation-link" href="javascript:void(0);"><span class="icon icon--logout"></span> Logout</a>
		<?php } ?>
	</div>
</div>