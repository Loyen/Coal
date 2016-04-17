<?php
namespace Coal\Core;

class dispatcher {
	private $hook = null;

	public function __construct() {
		$this->hook = new hook();
	}

	public function dispatch($url = null, $code = 200) {
		try {
			try {
				$route = $this->hook->route($url);

				$module = $this->initModule($route->module, $route->action);
				return $module->_execute($route->action, $route->args);
			} catch (hookErrorException $e) {
				throw new dispatchErrorException($e->getMessage(), $e->getCode());
			} catch (moduleErrorException $e) {
				throw new dispatchErrorException($e->getMessage(), $e->getCode());
			}
		} catch (dispatchErrorException $e) {
			if ($code !== 200) {
				$http = new http();
				$http->setStatusCode($e->getCode());
				if (setting::get('mode') == 'debug')
					print $e->getMessage();
				exit;
			}

			if ($e->getCode() === 403)
				$url = setting::get('page_access_denied', null);
			else
				$url = setting::get('page_not_found', null);

			return $this->dispatch($url, $e->getCode());
		}
	}

	public function initModule($module, $action) {
		$module_name = $module.'Module';
		$module_path = MODULE.$module_name.'.php';
		if (file_exists($module_path))
			require_once($module_path);

		if (!class_exists($module_name))
			throw new moduleErrorException('Module not found', 404);

		try {
			$module = new $module_name();
		} catch (helperErrorException $e) {
			throw new moduleErrorException('Module dependency failed to load', 404);
		}

		if (!method_exists($module, $action))
			throw new moduleErrorException('Module action not found', 404);

		if (!$module->_authorization())
			throw new moduleErrorException('Forbidden', 403);

		return $module;
	}
}

class dispatchErrorException extends errorException {

}