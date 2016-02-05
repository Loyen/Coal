<?php
class session {
	public static $vars = [];

	/**
	 * Get session data by key
	 *
	 * @param string $key
	 *  Key to get
	 * @param mixed $default
	 *  Default value if key not found
	 * @param bool $strict
	 *  If strict check return default if value is empty
	 * @return mixed variable found on key or $default value
	 **/
	public static function get($key, $default = null, $strict = false) {
		if (isset(self::$vars[$key]))
		{
			if ($strict && empty(self::$vars[$key])) return $default;

			return self::$vars[$key];
		}

		return $default;
	}

	/**
	 * Set session data to key
	 *
	 * @param string $key
	 *  Key to set
	 * @param mixed $value
	 *  Value to set
	 **/
	public static function set($key, $value) {
		self::$vars[$key] = $value;
	}

	/**
	 * Delete session data by key
	 *
	 * @param string $key
	 *  Key to delete
	 * @return bool true if successful else false
	 **/
	public static function delete($key) {
		if (isset(self::$vars[$key]))
		{
			unset(self::$vars[$key]);
			return true;
		}

		return false;
	}

	/**
	 * Copy session data to self::$vars
	 **/
	public static function fetch() {
		self::$vars = $_SESSION;
	}

	/**
	 * Copy self::$vars to session data
	 **/
	public static function write() {
		$_SESSION = self::$vars;
	}

	/**
	 * Start session
	 **/
	public static function start() {
		session_start();
		self::fetch();
	}

	/**
	 * Delete session data
	 **/
	public static function end() {
		self::$vars = [];
		session_destroy();
	}
}