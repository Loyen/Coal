<?php
namespace Coal\Core;

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

		$module = $this->initModule($route->module, $route->action);

		if (!$module)
			return $this->dispatch_error(404);

		if (!$module->_authorization())
			return $this->dispatch_error(403);

		return $module->_execute($route->action, $route->args);
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

			$module = $this->initModule($route->module, $route->action);

			if (!$module)
				throw new Exception(404);

			if (!$module->_authorization())
				throw new Exception(403);
		} catch (Exception $e) {
			$http = new http();
			$http->setStatusCode($code);
			exit;
		}

		return $module->_execute($route->action, $route->args);
	}

	public function initModule($module, $action) {
		$module_name = $module.'Module';
		$module_path = MODULE.$module_name.'.php';
		if (file_exists($module_path))
			require_once($module_path);

		if (!class_exists($module_name))
			return null;

		$module = new $module_name();

		if (!method_exists($module, $action))
			return null;

		return $module;
	}
}