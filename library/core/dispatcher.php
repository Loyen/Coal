<?php
class dispatcher {
	private $hook = null;

	public function __construct() {
		$this->hook = new hook();
	}

	public function dispatch() {
		$output = '';
		$route = $this->hook->route();
		if (!$route)
			return $this->dispatch_error(404);

		$appController = $this->initController($route->controller, $route->action);

		if (!$appController)
			return $this->dispatch_error(404);

		if (!$appController->_authorization())
			return $this->dispatch_error(403);

		return $this->executeController($appController, $route->action, $route->args);
	}

	public function dispatch_error($code = 404) {
		try {
			if ($code == 403)
				$url = setting::get('page_access_denied', null);
			else
				$url = setting::get('page_not_found', null);

			if (!$url)
				throw new Exception(404);

			$route = $this->hook->route($url);
			if (!$route)
				throw new Exception(404);

			$appController = $this->initController($route->controller, $route->action);

			if (!$appController)
				throw new Exception(404);

			if (!$appController->_authorization())
				throw new Exception(403);
		} catch (Exception $e) {
			$http = new http();
			$http->setStatusCode($code);
			exit;
		}

		return $this->executeController($appController, $route->action, $route->args);
	}

	public function initController($controller, $action) {
		$controller_path = APPLICATION.$controller.DS.'_controller.php';
		$controller_name = $controller.'Controller';
		if (file_exists($controller_path))
			require_once($controller_path);

		if (!class_exists($controller_name))
			return null;

		$appController = new $controller_name();

		if (!method_exists($appController, $action))
			return null;

		return $appController;
	}

	public function executeController($controller, $action, $args = []) {
		$controller->_before();
		$output = call_user_func_array([$controller, $action], $args);
		$controller->_after();
		return $output;
	}
}