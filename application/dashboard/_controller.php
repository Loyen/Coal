<?php
class dashboardController extends controller {
	public function _before() {
		theme::load('nitrogen');
	}

	public function index() {
		return theme::render('default');
	}
}