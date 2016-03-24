<?php
class dispatcher {
	private $hook = null;
	public function __construct() {
		$this->hook = new hook();
	}
	public function dispatch() {
		$route = $this->hook->route();

		return $this->execute($route->controller, $route->action, $route->args);
	}

	public function execute_error($code = 404) {
		return $this->execute($this->hook->setting('error', 'error'), null, [$code]);
	}

	public function execute($controller, $action = null, $args = []) {
		if ($controller) {
			$controller_path = APPLICATION.$controller.DS.'_controller.php';
			$controller_name = $controller.'Controller';
			if (file_exists($controller_path))
				require_once($controller_path);

			if (!class_exists($controller_name))
				return 404;

			$appController = new $controller_name();

			if ($action === null)
				$action = $this->hook->setting('action', 'index');

			if (method_exists($appController, '_authorization')) {
				if (!$appController->_authorization()) {
					return 403;
				}
			}

			if (property_exists($appController, 'helpers')) {
				$helpers = $appController->helpers;
				foreach ($helpers as $helper) {
					$helper_name = $helper.'Helper';
					$helper_path = HELPER.$helper_name.'.php';
					if (file_exists($helper_path))
						require_once($helper_path);

					$appController->$helper_name = new $helper_name();
				}
			}

			if (method_exists($appController, $action)) {
				if (method_exists($appController, '_before'))
					$appController->_before();

				$output = call_user_func_array([$appController, $action], $args);

				if (method_exists($appController, '_after'))
					$appController->_after();

				return $output;
			}
		}

		return 404;
	}
}