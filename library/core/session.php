<?php
class session {
	public static $vars = [];

	public static function get($key, $default = null) {
		if (isset(self::$vars[$key]))
			return self::$vars[$key];

		return $default;
	}

	public static function set($key, $value) {
		self::$vars[$key] = $value;
	}
}