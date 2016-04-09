<?php
namespace Coal\Core;

class theme {
	private $theme = null;
	private $hooks = null;
	private $variables = [];
	private $renderer = null;

	public function __construct() {
		$this->renderer = new renderer();

		$this->load(setting::get('theme', 'default'));
		$this->variables['favicon'] = str_replace(['/', '\\'], DS, setting::get('favicon', 'favicon.ico'));
		$this->variables['site_title'] = setting::get('site_title', null);
		$this->variables['site_description'] = setting::get('site_description', null);
		$this->variables['theme'] = &$this;
	}

	public function addStyle($styles = []) {
		if (!is_array($styles)) $styles = func_get_args();

		foreach ($styles as $style) {
			$style = $this->_theme_path().str_replace(['/', '\\'], DS, $style);
			$this->variables['styles'][] = $style;
		}
	}

	public function addScript($scripts = []) {
		if (!is_array($scripts)) $scripts = func_get_args();

		foreach ($scripts as $script) {
			$script = $this->_theme_path().str_replace(['/', '\\'], DS, $script);
			$this->variables['scripts'][] = $script;
		}
	}

	public function load($theme = null) {
		if (empty($theme))
			return false;

		if ($this->theme === $theme)
			return true;

		$this->theme = $theme;
		$this->hooks = [];

		$this->variables['styles'] = [];
		$this->variables['scripts'] = [];

		if ($data = json_parse_file(THEME.$theme.DS.'theme.json')) {
			if (!isset($data->styles)) $data->styles = [];
			if (!isset($data->scripts)) $data->scripts = [];

			$this->addStyle($data->styles);
			$this->addScript($data->scripts);
		}

		if ($hooks = json_parse_file(THEME.$theme.DS.'hooks.json')) {
			$this->hooks = $hooks;
			return true;
		}

		return false;
	}

	public function render($hookname, $vars = []) {
		$output = '';
		if ($hook = $this->_hook($hookname, $vars)) {
			$file = $this->_hook_path($hook->file, (isset($hook->path) ? $hook->path : null));
			$vars = $this->variables;
			foreach ($hook->args as $key => $val) {
				$vars[$key] = $val;
			}
			$output = $this->renderer->print($file, $vars);

			if (isset($hook->template)) {
				$this->variables['content'] = $output;
				$output = $this->render($hook->template, $this->variables);
			}

			$this->variables = [];
		}

		return $output;
	}

	private function _hook($hookname = null, $vars = []) {
		if ($this->hooks === null)
			$this->load();

		if (isset($this->hooks->$hookname)) {
			$hook = $this->hooks->$hookname;
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

	private function _theme_path() {
		return '/'.substr(THEME, strlen(ROOT)).$this->theme.DS;
	}

	private function _hook_path($filename, $path = '') {
		return THEME.$this->theme.DS.(!empty($path) ? str_replace(['/', '\\'], DS, $path).DS : '').$filename.'.tpl';
	}
}