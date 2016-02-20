<?php
class defaultController extends controller {
	public function index() {
		return theme::render('default');
	}
}