<?php
class errorController extends controller {
	public function index($code = 404) {
		if (http::status_code($code) !== false) {
			$codes = http::$status_codes;
			$title = $codes[$code].' (Code: '.$code.')';
			$description = '';

			if ($code == 403) {
				$description = 'The page requested requires extra permissions to be seen.';
			} elseif ($code == 404) {
				$description = 'The page requested could not be found.';
			}
		} else {
			$title = 'Unknown error occured';
			$description = 'An error occured trying to find the requested page.';
		}

		return theme::render('error', ['title' => $title, 'description' => $description]);
	}
}