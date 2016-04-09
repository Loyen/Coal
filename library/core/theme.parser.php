<?php
namespace Coal\Core;

class themeParser {
	private $themeHandler = null;

	public function __construct(theme &$theme) {
		$this->themeHandler = $theme;
	}

	public function render($template, $vars = []) {
		return $this->themeHandler->render($template, $vars);
	}
}