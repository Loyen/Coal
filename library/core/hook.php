<?php
class hook {
	private $hooks = null;

	private function fetch() {
		if ($json_decoded = json_parse_file(CONFIG.'hooks.json')) {
			$this->hooks = (array) $json_decoded;
			return true;
		}

		return false;
	}

	public function setting($var) {
		$setting = setting::get('hook', (object)[]);

		if (isset($setting->$var))
			return $setting->$var;

		return null;
	}

	public function url() {
		$hook_param = $this->setting('parameter', 'q');
		if (isset($_GET[$hook_param]) && !empty($_GET[$hook_param]) && $_GET[$hook_param] !== '/')
			$url = $_GET[$hook_param];
		else
			$url = $this->setting('default');

		return $url;
	}

	public function route($url = null) {
		if ($this->hooks === null)
			$this->fetch();

		if (is_null($url))
			$url = $this->url();

		$url = trim($url, '/');

		$url_pieces = explode('/', $url);
		$hook_valid = null;
		$hook_valid_level = 0;
		foreach ($this->hooks as $hook_url => $hook) {
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

			return $hook;
		}

		return null;
	}
}