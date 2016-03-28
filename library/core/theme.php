<?php
class theme {
	private $theme = null;
	private $hooks = null;
	private $variables = [];

	public function __construct() {
		$this->load(setting::get('theme', 'default'));
	}

	public function addStyle($styles = []) {
		if (!is_array($styles)) $styles = func_get_args();

		foreach ($styles as $style) {
			$style = $this->_root().str_replace(['/', '\\'], DS, $style);
			$this->variables['styles'][] = $style;
		}
	}

	public function addScript($scripts = []) {
		if (!is_array($scripts)) $scripts = func_get_args();

		foreach ($scripts as $script) {
			$script = $this->_root().str_replace(['/', '\\'], DS, $script);
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
			$file = THEME.$this->theme.DS.(isset($hook->path) ? $hook->path.DS : '').$hook->file.'.tpl';
			$vars = $hook->args;
			$output = $this->_getContent($file, $vars);

			if (isset($hook->template)) {
				$output = $this->_renderTemplate($hook->template, $output);
			}
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

	private function _getContent($_file, $_vars) {
		$_output = '';
		if (file_exists($_file)) {
			ob_start();
			extract($_vars);
			include($_file);
			$_output = ob_get_contents();
			ob_end_clean();
		}

		return $_output;
	}

	private function _renderTemplate($templatename, $content) {
		$output = '';
		if ($hook = $this->_hook($templatename, [])) {
			$file = THEME.$this->theme.DS.(isset($hook->path) ? $hook->path.DS : '').$hook->file.'.tpl';
			$vars = $this->variables;
			$vars['content'] = $content;
			$output = $this->_getContent($file, $vars);
		}

		return $output;
	}

	private function _root() {
		return '/'.substr(THEME, strlen(ROOT)).$this->theme.DS;
	}
}