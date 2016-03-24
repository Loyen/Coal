<?php
class cacheHelper extends helper {
	private $cacheHandler = null;

	public function __construct() {
		$this->cacheHandler = new cache();
	}

	public function read($key, $default = null) {
		return $this->cacheHandler->read($key, $default);
	}

	public function write($key, $value, $expiration = 0) {
		return $this->cacheHandler->write($key, $value, $expiration);
	}
}