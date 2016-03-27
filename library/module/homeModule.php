<?php
class homeModule extends module {
	public function index() {
		return theme::render('default');
	}
}