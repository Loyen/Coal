<?php
class setting {
	private static $vars = null;

	public static function fetch() {
		if ($json_decoded = json_parse_file(CONFIG.'settings.json')) {
			self::$vars = $json_decoded;
			return true;
		}

		return false;
	}

	public static function get($var, $default = null) {
		if (self::$vars === null)
			self::fetch();

		if (isset(self::$vars->$var))
			return self::$vars->$var;

		return $default;
	}

	public static function set($var, $value) {
		self::$vars[$var] = $value;
	}
}