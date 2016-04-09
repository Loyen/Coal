<?php
class homeModule extends \Coal\Core\module {
	public function index() {
		return $this->theme->render('default');
	}
}