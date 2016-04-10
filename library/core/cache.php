<?php
namespace Coal\Core;

class cache {
	private $cacheHandler = null;

	public function __construct() {
		$cache_method = setting::get('cache_method', 'file');

		$file = CORE.'cache'.DS.'cache.'.strtolower($cache_method).'.php';
		if (file_exists($file)) {
			require_once($file);
			$cache_method_name = 'cache_'.$cache_method;
			if (class_exists('\\Coal\\Core\\'.$cache_method_name)) {
				$this->cacheHandler = new $cache_method();

				if ($this->cacheHandler !== false)
					return true;

			}
		}

		return false;
	}

	public function clear() {
		return $this->cacheHandler->clear();
	}

	public function read($key, $default = null) {
		if (!$this->exists($key))
			return $default;

		return $this->cacheHandler->read($key);
	}

	public function exists($key) {
		return $this->cacheHandler->exists($key);
	}

	public function delete($key) {
		return $this->cacheHandler->delete($key);
	}

	public function write($key, $value, $expiration = 0) {
		return $this->cacheHandler->write($key, $value, $expiration);
	}
}