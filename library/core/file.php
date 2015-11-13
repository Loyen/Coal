<?php
class file {
	public static function read($file) {
		if (file_exists($file)) {
			if ($content = file_get_contents($file)) {
				return $content;
			}
		}

		return false;
	}

	public static function write($file, $value, $force = true) {
		if (!file_exists($file) || $force) {
			if (is_string($value) && file_put_contents($file, $value, LOCK_EX))
				return true;
		}

		return false;
	}

	public static function delete($file) {
		if (file_exists($file)) {
			if (unline($file)) {
				return true;
			}
		}

		return false;
	}
}