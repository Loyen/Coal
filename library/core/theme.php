<?php
class theme {
	private static
		$theme = null,
		$hooks = null;

	public static function load($theme = null) {
		if (self::$theme === setting::get('theme', 'default'))
			return true;

		if ($theme === null)
			$theme = setting::get('theme', 'default');

		self::$theme = $theme;
		self::$hooks = [];

		if ($hooks = json_parse_file(THEME.$theme.DS.'hooks.json')) {
			self::$hooks = $hooks;
			return true;
		}


		return false;
	}

	public static function hook($hookname = null, $vars = []) {
		if (self::$hooks === null)
			self::load();

		if (isset(self::$hooks->$hookname)) {
			$hook = self::$hooks->$hookname;
			if (isset($hook->args) && !empty($hook->args)) {
				// Convert object to string
				$hook->args = (array) $hook->args;

				foreach ($hook->args as $key => &$arg) {
					if (isset($vars[$key]))
						$arg = $vars[$key];
				}
			} else {
				$hook->args = [];
			}
			return $hook;
		}

		return false;
	}

	public static function render($hookname, $vars = []) {
		$output = '';
		if ($hook = self::hook($hookname, $vars)) {
			$file = THEME.self::$theme.DS.(isset($hook->path) ? $hook->path.DS : '').$hook->file.'.tpl';
			$vars = $hook->args;
			if (file_exists($file))
			{
				extract($vars);
				ob_start();
				include($file);
				$output = ob_get_contents();
				ob_end_clean();
			}

			if (isset($hook->template)) {
				$output = self::render($hook->template, ['content' => $output]);
			}
		}
		return $output;
	}
}