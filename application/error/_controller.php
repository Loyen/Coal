<?php
class errorController extends controller {
	public function index($code = 404) {
		if ($code == 403) {
			$title = '403 Page forbidden';
			$description = 'The page requested requires extra permissions to be seen.';
		}
		elseif ($code == 404) {
			$title = '404 Page not found';
			$description = 'The page requested could not be found.';
		} else{
			$title = 'Unknown error occured';
			$description = 'An error occured trying to find the requested page.';
		}

		return theme::render('error', ['title' => $title, 'description' => $description]);
	}
}