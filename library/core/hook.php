<?php
namespace Coal\Core;

class hook {
	private $hooks = null;

	private function fetch() {
		if ($json_decoded = json_parse_file(CONFIG.'hooks.json')) {
			$this->hooks = (array) $json_decoded;
			return true;
		}

		return false;
	}

	public function route($url = null) {
		if ($this->hooks === null)
			$this->fetch();

		if (empty($this->hooks))
			return null;

		if (is_null($url))
			$url = url();

		$url = trim($url, '/');

		if (empty($url))
			$url = setting::get('page_home', 'home');

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

			if (count($hook_url_pieces) > count($url_pieces))
				continue;

			$valid_level = 0;
			for ($i=0;$i<count($url_pieces);$i++) {
				if ($hook_url_pieces[$i] !== $url_pieces[$i] && $hook_url_pieces[$i] !== '*') {
					$valid_level = 0;
					break;
				}

				$valid_level++;
			}

			if ($valid_level === 0 || $valid_level < $hook_valid_level)
				continue;

			$hook_valid = $hook;
			$hook_valid_level = $valid_level;
		}

		if (!$hook_valid)
			return null;

		$hook = $hook_valid;
		$hook->url = $url;
		if (isset($hook->args) && !empty($hook->args)) {
			// Convert object to string
			$hook->args = (array) $hook->args;

			foreach ($hook->args as &$arg) {
				if (is_int($arg))
					$arg = arg($arg, $url);
			}
		} else {
			$hook->args = [];
		}

		if (!isset($hook->action))
			$hook->action = setting::get('default_action', 'index');

		return $hook;
	}
}