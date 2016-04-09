<?php
class userHelper extends \Coal\Core\helper {
	private $user = [];
	private $sessionHandler = null;

	public function __construct() {
		$this->sessionHandler = new \Coal\Core\session();
	}

	public function set($key, $value) {
		$this->user[$key] = $value;
		$this->sessionHandler->set('user', $this->user);
	}

	public function has($key, $strict = false) {
		return (isset($this->user[$key]) ? ($strict ? !empty($this->user[$key]) : true) : false);
	}

	public function delete($key) {
		if (isset($this->user[$key]))
		{
			unset($this->user[$key]);
			$this->sessionHandler->set('user', self::$user);
			return true;
		}

		return false;
	}

	public function anonymous() {
		return (self::get('id', 0) === 0);
	}

	public function load() {
		if (session::active())
		{
			$this->user = $this->sessionHandler->get('user', []);
		}

		// Create anonymous user if no user loaded
		if (empty(self::$user)) {
			$this->set('id', 0);
			$this->set('name', 'Anonymous');
			$this->set('username', 'anonymous');

			$this->sessionHandler->set('user', self::$user);
		}
	}
}