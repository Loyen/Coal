<?php
namespace Coal\Module;

class home extends \Coal\Core\module {
	public function index() {
		return $this->theme->render('default');
	}
}
