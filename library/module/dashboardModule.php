<?php
class dashboardModule extends module {
	public function _before() {
		theme::load('nitrogen');
	}

	public function index() {
		return theme::render('default');
	}
}