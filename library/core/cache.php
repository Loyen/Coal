<?php
namespace Coal\Core;

class cache {
	public function read($key, $default = null) {
		$cache_key = md5($key);
		if (class_exists('Memcache')) {
			if ($cache = Memcache::get($cache_key)) {
				return unserialize($cache);
			}
		} else {
			$file = new file(CACHE.$cache_key);
			if ($cache = $file->read()) {
				if (time() < $cache->expiration)
					return $cache->content;
				else
					$file->delete();
			}
		}

		return $default;
	}

	public function write($key, $value, $expiration = 0) {
		$cache_key = md5($key);

		if (class_exists('Memcache')) {
			$cache = serialize($value);
			if (Memcache::set($cache_key, $cache, MEMCACHE_COMPRESSED, $expiration))
				return true;
		} else {
			$cache = (object) [
				'content' => $value,
				'expiration' => time()+$expiration
			];
			$cache = serialize($cache);
			$file = new file(CACHE.$cache_key);
			if ($file->write($cache))
				return true;
		}

		return false;
	}
}