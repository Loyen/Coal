<?php
namespace Coal\Core;

class cache_memcache {
	public function __construct() {
		return extension_loaded('memcache');
	}

	public function clear() {
		return Memcache::flush();
	}

	public function read($key) {
		return Memcache::get($key);
	}

	public function exists($key) {
		return Memcache::get($key) !== false;
	}

	public function delete($key) {
		return Memcache::delete($key);
	}

	public function write($key, $value, $expire) {
		return Memcache::set($key, $value, MEMCACHE_COMPRESSED, $expire);
	}

}