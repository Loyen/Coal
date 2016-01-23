<!DOCTYPE html>
<html lang="en" class="document">
<head>
	<title>Coal</title>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link rel="stylesheet" type="text/css" href="/theme/nitrogen/style/all.css" />
	<script src="/theme/nitrogen/script/jquery-1.11.3.min.js"></script>
	<script src="/theme/nitrogen/script/core.js"></script>

</head>
<body>
<div class="siteNavigation">
	<?php echo theme::render('navigation-sidebar'); ?>
</div> <!-- .siteNavigation -->
<div class="siteHeader">
	<?php echo theme::render('navigation-header'); ?>
</div> <!-- .siteHeader -->
<div class="siteMain">
	<div class="siteContent">
		<?php echo $content; ?>
	</div> <!-- .siteContent -->
</div> <!-- .siteMain -->
</body>
</html>