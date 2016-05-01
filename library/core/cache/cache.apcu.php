<?php
namespace Coal\Core;

class cache_apcu {
	public function __construct() {
	}

	public function clear() {
		return apc_clear_cache();
	}

	public function read($key) {
		return apc_fetch($key);
	}

	public function delete($key) {
		return apc_delete($key);
	}

	public function write($key, $value, $expire) {
		return apc_store($key, $value, $expire);
	}

}