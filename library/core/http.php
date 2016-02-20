<?php
class http {
	public static function header($value) {
		return header($value);
	}

	public static function protocol() {
		return $_SESSION['SERVER_PROTOCOL'];
	}

	public static function status_code($code = 200) {
		$codes = [
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

		if (!isset($codes[$code])) return false;

		return header(self::protocol().' '.$code.' '.$codes[$code]);

	}

	public static function redirect($url, $code = 301) {
		session::write();

		self::status_code($code);
		self::header('Location: '.$url);
	}
}