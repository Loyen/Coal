<?php
class module {
	public $helpers = [];

	public function _authorization() { return true; }

	public function _before() {}
	public function _after() {}

	public function __construct() {
		if (!empty($this->helpers)) {
			foreach ($this->helpers as $helper) {
				$helper_name = $helper.'Helper';
				$helper_path = HELPER.$helper_name.'.php';
				if (file_exists($helper_path))
					require_once($helper_path);

				$this->$helper_name = new $helper_name();
			}
		}
	}
}