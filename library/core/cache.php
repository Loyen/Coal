<?php
namespace Coal\Core;

class cache {
	private $cacheHandler = null;

	public function __construct() {
		$cache_method = setting::get('cache_method', 'file');

		$file = CORE.'cache'.DS.'cache.'.strtolower($cache_method).'.php';
		if (file_exists($file))
			require_once($file);

		$cache_method_name = '\\Coal\\Core\\cache_'.$cache_method;
		if (!class_exists($cache_method_name))
			throw new cacheErrorException('No cacheHandler found', 404);

		$this->cacheHandler = new $cache_method_name();
	}

	public function clear() {
		return $this->cacheHandler->clear();
	}

	public function read($key, $default = null) {
		$key = md5($key);
		$data = $this->cacheHandler->read($key);

		if (!$data)
			return $default;

		return $data;
	}

	public function delete($key) {
		$key = md5($key);
		return $this->cacheHandler->delete($key);
	}

	public function write($key, $value, $expiration = 0) {
		$key = md5($key);
		return $this->cacheHandler->write($key, $value, $expiration);
	}
}

class cacheErrorException extends errorException {

}
