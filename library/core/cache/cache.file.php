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

		if (!$file->exists())
			return null;

		$data = $file->read();
		$object = unserialize($data);

		if (!$object || ($object->expire !== 0 && $object->expire > time()))
			return null;

		return $object->data;
	}

	public function delete($key) {
		$file = new file(CACHE.$key);
		return $file->delete();
	}

	public function write($key, $value, $expire) {
		$file = new file(CACHE.$key);
		$object = (object) [
			'data' => $value,
			'expire' => ($expire > 0 ? time()+$expire : 0)
		];
		$data = serialize($object);
		return $file->write($data);
	}

}