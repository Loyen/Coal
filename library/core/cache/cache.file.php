<?php
namespace Coal\Core;

class cache_file {
	public function __construct() {
	}

	public function clear() {
		return true;
	}

	public function read($key) {
		$file = new file(CACHE.$key);
		return $file->read();
	}

	public function exists($key) {
		$file = new file(CACHE.$key);
		return $file->exists();
	}

	public function delete($key) {
		$file = new file(CACHE.$key);
		return $file->delete();
	}

	public function write($key, $value, $expire) {
		$file = new file(CACHE.$key);
		return $file->write($value);
	}

}