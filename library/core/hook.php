<?php
class hook {
	private static $hooks = null;

	public static function fetch() {
		if ($json_decoded = json_parse_file(CONFIG.'hooks.json')) {
			self::$hooks = $json_decoded;
			return true;
		}

		return false;
	}

	public static function setting($var) {
		$setting = setting::get('hook', (object)[]);

		if (isset($setting->$var))
			return $setting->$var;

		return null;
	}

	public static function get($url = null) {
		if (self::$hooks === null)
			self::fetch();

		if (is_null($url))
			$url = url();

		if (isset(self::$hooks->$url)) {
			$hook = self::$hooks->$url;
			$hook->url = $url;
			if (isset($hook->args) && !empty($hook->args)) {
				// Convert object to string
				$hook->args = (array) $hook->args;

				foreach ($hook->args as &$arg) {
					if (is_int($arg))
						$arg = arg($arg);
				}
			} else {
				$hook->args = [];
			}
			return $hook;
		}

		return false;
	}

	public static function execute($url = null) {
		if ($hook = self::get($url)) {
			if (isset($hook->controller)) {
				$controller = $hook->controller.'Controller';
				if (file_exists(CONTROLLER.$controller.'.php'))
					require_once(CONTROLLER.$controller.'.php');

				if (!isset($hook->action))
					$hook->action = self::setting('action', 'index');

				$action = $hook->action;

				if (isset($hook->theme))
					theme::load($hook->theme);

				if (method_exists($controller, '_authorization')) {
					if (!call_user_func([$controller, '_authorization']))
						return 403;
				}

				if (method_exists($controller, $action)) {

					if (method_exists($controller, '_before'))
						return call_user_func([$controller, '_before']);

					$args =(isset($hook->args) ? $hook->args : []);
					return call_user_func_array([$controller, $action], $args);

					if (method_exists($controller, '_after'))
						return call_user_func([$controller, '_after']);
				}
			}
		}

		return 404;
	}
}