<?php
class hook {
	private static $hooks = null;

	public static function fetch() {
		if ($json_decoded = json_parse_file(CONFIG.'hooks.json')) {
			self::$hooks = (array) $json_decoded;
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

	public static function route($url = null) {
		if (self::$hooks === null)
			self::fetch();

		if (is_null($url))
			$url = url();

		$url = trim($url, '/');

		$url_pieces = explode('/', $url);
		$hook_valid = null;
		$hook_valid_level = 0;
		foreach (self::$hooks as $hook_url => $hook) {
			$hook->url = trim($hook_url, '/');
			if ($hook->url === $url) {
				$hook_valid = $hook;
				break;
			}

			$hook_url_pieces = explode('/', $hook->url);

			if (count($hook_url_pieces) > count($url_pieces)) continue;

			$valid_level = 0;
			for ($i=0;$i<count($url_pieces);$i++) {
				if ($hook_url_pieces[$i] !== $url_pieces[$i] && $hook_url_pieces[$i] !== '*') {
					$valid_level = 0;
					break;
				}

				$valid_level++;
			}

			if ($valid_level === 0 || $valid_level < $hook_valid_level) continue;

			$hook_valid = $hook;
			$hook_valid_level = $valid_level;
		}

		if ($hook_valid) {
			$hook = $hook_valid;
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

			if (!isset($hook->action)) $hook->action = null;

			return self::execute($hook->controller, $hook->action, $hook->args);
		}

		return 404;
	}

	public static function execute($controller, $action = null, $args = []) {
		if ($controller) {
			$controller_path = APPLICATION.$controller.DS.'_controller.php';
			$controller_name = $controller.'Controller';
			if (file_exists($controller_path))
				require_once($controller_path);

			if ($action === null)
				$action = self::setting('action', 'index');

			if (method_exists($controller_name, '_authorization')) {
				if (!call_user_func([$controller_name, '_authorization'])) {
					return 403;
				}
			}

			if (property_exists($controller_name, 'plugins') && method_exists($controller, '_loadPlugins')) {
				call_user_func([$controller_name, '_loadPlugins']);
			}

			if (method_exists($controller_name, $action)) {
				if (method_exists($controller_name, '_before'))
					call_user_func([$controller_name, '_before']);

				$output = call_user_func_array([$controller_name, $action], $args);

				if (method_exists($controller_name, '_after'))
					call_user_func([$controller_name, '_after']);

				return $output;
			}
		}

		return 404;
	}
}