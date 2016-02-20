<?php
function arg($pos = null) {
	$args = explode('/', trim(url(), '/'));

	if ($pos === null)
		return $args;

	if (isset($args[$pos]))
		return $args[$pos];

	return null;
}

function debug() {
	$args = func_get_args();
	echo '<pre>';
	foreach ($args as $arg) {
		echo json_encode($arg, JSON_PRETTY_PRINT);
		//echo print_r($arg, true);
		//echo var_export($arg);
	}
	echo '<pre>';
}

function json_parse_file($file) {
	if (file_exists($file)) {
		$json = file_get_contents($file);
		if ($json_decoded = json_decode($json)) {
			return $json_decoded;
		}
	}

	return false;
}

function url($url = null) {
	if ($url === null) {
		$hook_param = hook::setting('parameter', 'q');
		if (isset($_GET[$hook_param]) && !empty($_GET[$hook_param]) && $_GET[$hook_param] !== '/')
			$url = $_GET[$hook_param];
		else
			$url = hook::setting('default', 'home');
	}

	return $url;
}