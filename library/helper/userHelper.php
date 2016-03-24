<?php
class userHelper extends helper {
	private $user = [];

	/**
	 * Get user data by key
	 *
	 * @param string $key
	 *  Key to get
	 * @param mixed $default
	 *  Default value if key not found
	 * @param bool $strict
	 *  If strict check return default if value is empty
	 * @return mixed variable found on key or $default value
	 **/
	public function get($key, $default = null, $strict = false) {
		if (self::has($key, $strict))
			return self::$user[$key];

		return $default;
	}

	/**
	 * Set user data to key
	 *
	 * @param string $key
	 *  Key to set
	 * @param mixed $value
	 *  Value to set
	 **/
	public function set($key, $value) {
		self::$user[$key] = $value;
		session::set('user', self::$user);
	}

	/**
	 * Check if user data has key
	 *
	 * @param string $key
	 *  Key to set
	 * @param bool $strict
	 *  If strict check return default if value is empty
	 * @return bool if exists (and if strict, is not empty) true else false
	 **/
	public function has($key, $strict = false) {
		return (isset(self::$user[$key]) ? ($strict ? !empty(self::$user[$key]) : true) : false);
	}

	/**
	 * Delete user data by key
	 *
	 * @param string $key
	 *  Key to delete
	 * @return bool true if successful else false
	 **/
	public function delete($key) {
		if (isset(self::$user[$key]))
		{
			unset(self::$user[$key]);
			session::set('user', self::$user);
			return true;
		}

		return false;
	}

	/**
	 * Get user status
	 *
	 * @return string user status
	 **/
	public function anonymous() {
		return (self::get('id', 0) === 0);
	}

	/**
	 * Load user from session data
	 **/
	public function load() {
		if (session::active())
		{
			self::$user = session::get('user', []);
		}

		// Create anonymous user if no user loaded
		if (empty(self::$user)) {
			self::set('id', 0);
			self::set('name', 'Anonymous');
			self::set('username', 'anonymous');

			session::set('user', self::$user);
		}
	}
}