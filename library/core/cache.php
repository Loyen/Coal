<?php
class cache {
	public static function read($key, $default = null) {
		if (isset(self::$vars[$key]))
			return self::$vars[$key];

		return $default;
	}

	public static function write($key, $value) {
		self::$vars[$key] = $value;
	}
}