<?php
class session {
	public function __construct() {
		$this->start();
	}

	public function __destruct() {
		$this->end();
	}

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
	public function get($key, $default = null, $strict = false) {
		if ($this->has($key, $strict))
			return $_SESSION[$key];

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
	public function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * Check if session data has key
	 *
	 * @param string $key
	 *  Key to set
	 * @param bool $strict
	 *  If strict check return default if value is empty
	 * @return bool if exists (and if strict, is not empty) true else false
	 **/
	public function has($key, $strict = false) {
		return (isset($_SESSION[$key]) ? ($strict ? !empty($_SESSION[$key]) : true) : false);
	}

	/**
	 * Delete session data by key
	 *
	 * @param string $key
	 *  Key to delete
	 * @return bool true if successful else false
	 **/
	public function delete($key) {
		if (isset($_SESSION[$key]))
		{
			unset($_SESSION[$key]);
			return true;
		}

		return false;
	}

	/**
	 * Start session
	 **/
	public function start() {
		if ($this->isActive()) return true;
		if (!session_start()) return false;
		return true;
	}

	/**
	 * Check if session is active
	 **/
	public function isActive() {
		return session_id() !== '';
	}
	/**
	 * End session
	 **/
	public function end() {
		if (!$this->isActive()) return true;

		session_write_close();
		return true;
	}

	/**
	 * Destroy session
	 **/
	public function destroy() {
		if (!$this->isActive()) return true;

		session_destroy();
		return true;
	}

}