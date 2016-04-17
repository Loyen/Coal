<?php
class dashboardModule extends \Coal\Core\module {
	public function _authorization() {
		return false;
	}

	public function _before() {
		$this->theme->addStyle('style/override/admin.css');
	}

	public function index() {
		return $this->theme->render('default');
	}
}