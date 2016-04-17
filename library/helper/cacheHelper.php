<?php
class cacheHelper extends \Coal\Core\helper {
	private $cacheHandler = null;

	public function __construct() {
		try {
			$this->cacheHandler = new \Coal\Core\cache();
		} catch (\Coal\Core\cacheErrorException $e) {
			throw new helperErrorException('CacheHandler not found', 404);
		}
	}

	public function clear() {
		return $this->cacheHandler->clear();
	}

	public function read($key, $default = null) {
		return $this->cacheHandler->read($key, $default);
	}

	public function exists($key) {
		return $this->cacheHandler->exists($key);
	}

	public function delete($key) {
		return $this->cacheHandler->delete($key);
	}

	public function write($key, $value, $expire = 0) {
		return $this->cacheHandler->write($key, $value, $expire);
	}
}