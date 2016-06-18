<?php
namespace Coal\Module;

require_once 'user.d/login.php';
require_once 'user.d/register.php';

class user extends \Coal\Core\module {

	use User\login;
	use User\register;

	public function _authorization() {
		return true;
	}

	public function _before() {
		$this->theme->addStyle('style/override/admin.css');
	}

	public function index() {
		return $this->theme->render('default');
	}
}
