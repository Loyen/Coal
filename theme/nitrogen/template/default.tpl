<!DOCTYPE html>
<html lang="en" class="document">
<head>
	<title><?=$site_title;?></title>

	<link href="<?=$favicon;?>" rel="icon" type="image/x-icon" />

	<meta name="description" content="<?=$site_description;?>">

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
	<?=$theme->render('navigation-sidebar');?>
</div> <!-- .siteNavigation -->
<div class="siteHeader">
	<?=$theme->render('navigation-header');?>
</div> <!-- .siteHeader -->
<div class="siteMain">
	<div class="siteContent">
		<?=$content;?>
	</div> <!-- .siteContent -->
</div> <!-- .siteMain -->
</body>
</html>