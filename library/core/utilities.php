<?php
function arg($pos = null, $url = null) {
	if ($url === null) $url = url();
	$args = explode('/', trim($url, '/'));

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

function get_file_from_output_buffer($_file, $_vars = []) {
	$_output = '';
	if (file_exists($_file)) {
		ob_start();
		extract($_vars);
		include($_file);
		$_output = ob_get_contents();
		ob_end_clean();
	}

	return $_output;
}

function url($url = null, $args = []) {
	if ($url === null) {
		$hook_param = setting::get('parameter', 'q');
		if (isset($_GET[$hook_param]) && !empty($_GET[$hook_param]) && $_GET[$hook_param] !== '/')
			$url = $_GET[$hook_param];
		else
			$url = setting::get('page_home', 'home');
	}

	if ($url == setting::get('page_home', 'home')) {
		$url = '/';
	} else {
		$url = '/'.$url;
	}

	if (mb_strpos($url, '*')) {
		$limit = 1;
		while (!empty($args)) {
			$url = str_replace('*', array_shift($args), $url, $limit);
		}
	}

	return $url;
}