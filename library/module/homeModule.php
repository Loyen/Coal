<?php
class homeModule extends module {
	public function index() {
		return $this->theme->render('default');
	}
}