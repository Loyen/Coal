<?php
class httpHelper extends helper {
	private $httpHandler = null;

	public function __construct() {
		$this->httpHandler = new http();
	}

	public function getProtocol() {
		return $this->httpHandler->getProtocol();
	}

	public function setHeader($value) {
		return $this->httpHandler->setHeader($value);
	}

	public function getStatusCodes() {
		return $this->httpHandler->getStatusCodes();
	}

	public function setStatusCode($code = 200) {
		return $this->httpHandler->setStatusCode($code);
	}

	public function redirect($url, $code = 301) {
		return $this->httpHandler->redirect($url, $code);
	}
}