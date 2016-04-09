<?php
class sessionHelper extends \Coal\Core\helper {
	private $sessionHandler = null;

	public function __construct() {
		$this->sessionHandler = new session();
	}

	public function get($key, $default = null, $strict = false) {
		return $this->sessionHandler->has($key, $default, $strict);
	}

	public function set($key, $value) {
		return $this->sessionHandler->has($key, $value);
	}

	public function has($key, $strict = false) {
		return $this->sessionHandler->has($key, $strict);
	}

	public function delete($key) {
		return $this->sessionHandler->delete($key);
	}

	public function isActive() {
		return $this->sessionHandler->isActive();
	}


	public function destroy() {
		return $this->sessionHandler->destroy();
	}
}