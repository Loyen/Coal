<?php
class defaultController {
	public static function index() {
		return theme::render('default');
	}
}