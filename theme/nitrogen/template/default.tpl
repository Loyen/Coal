<!DOCTYPE html>
<html lang="en" class="document">
<head>
	<title>Coal</title>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

<?php foreach ($styles as $style) { ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $style; ?>" />
<?php } ?>

<?php foreach ($scripts as $script) { ?>
	<script src="<?php echo $script; ?>"></script>
<?php } ?>

</head>
<body>
<div class="siteNavigation">
	<?php echo $theme->render('navigation-sidebar'); ?>
</div> <!-- .siteNavigation -->
<div class="siteHeader">
	<?php echo $theme->render('navigation-header'); ?>
</div> <!-- .siteHeader -->
<div class="siteMain">
	<div class="siteContent">
		<?php echo $content; ?>
	</div> <!-- .siteContent -->
</div> <!-- .siteMain -->
</body>
</html>