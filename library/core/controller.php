<?php
class controller {
	public static $plugins = [];

	public static function _loadPlugins() {
		if (!is_array(self::$plugins)) return false;

		foreach (self::$plugins as $plugin) {
			plugin::load($plugin);
		}
	}
}