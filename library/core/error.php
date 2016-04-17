<?php
namespace Coal\Core;

class errorException extends \Exception {
	public function __construct($message = '', $code = 0) {
		$this->message = $message;
		$this->code = $code;
	}
}