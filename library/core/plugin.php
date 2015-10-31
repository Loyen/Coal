<?php
class plugin {
	private static $plugins = null;

	public static function load($plugin) {
		if (file_exists(PLUGIN.$plugin.'.php'))
		{
			if (!in_array($plugin, self::$plugins))
				self::$plugins[] = $plugin;

			require_once(PLUGIN.$plugin.'.php');
			return true;
		}

		return false;
	}

	public static function autoload() {
		$plugins = setting::get('plugins', []);

		if (is_array($plugins)) {
			foreach ($plugins as $plugin) {
				self::load($plugin);
			}
		}
	}
}