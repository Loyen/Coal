<?php
class dashboardController extends controller {
	public function index() {
		return theme::render('default');
	}
}