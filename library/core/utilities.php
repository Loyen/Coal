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

function url($url = null, $args = []) {
	static $hook;
	if (!$hook) $hook = new hook();

	if ($url === null) {
		$url = $hook->url();
	}

	if ($url === $hook->setting('default')) {
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