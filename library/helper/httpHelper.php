<?php
class httpHelper extends helper {
	public $status_codes = [
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',

		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Moved Temporarily',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',

		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Time-out',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Large',
		415 => 'Unsupported Media Type',
		418 => 'I\'m a teapot',

		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Time-out',
		505 => 'HTTP Version not supported',
	];

	public function getProtocol() {
		return $_SERVER['SERVER_PROTOCOL'];
	}

	public function setHeader($value) {
		return header($value);
	}

	public function setStatusCode($code = 200) {
		if (!isset($this->status_codes[$code])) return false;

		$this->setHeader($this->getProtocol().' '.$code.' '.$this->status_codes[$code]);
		return true;
	}

	public function redirect($url, $code = 301) {
		if (session::active()) session::write();

		$this->setStatusCode($code);
		$this->setHeader('Location: '.$url);
	}
}