<?php
class file {
	public static function exists($file) {
		return file_exists($file);
	}

	public static function read($file) {
		if (self::exists($file)) {
			if ($content = file_get_contents($file)) {
				return $content;
			}
		}

		return false;
	}

	public static function write($file, $value, $force = true) {
		if (!self::exists($file) || $force) {
			if (is_string($value) && file_put_contents($file, $value, LOCK_EX))
				return true;
		}

		return false;
	}

	public static function delete($file) {
		if (self::exists($file)) {
			if (unlink($file)) {
				return true;
			}
		}

		return false;
	}
}