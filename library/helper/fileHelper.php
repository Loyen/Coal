<?php
class fileHelper extends \Coal\Core\helper {
	private $fileHandler = null;

	public function __construct($file = null) {
		$this->fileHandler = new \Coal\Core\file($file);
	}

	public function exists() {
		return $this->fileHandler->exists();
	}

	public function read() {
		return $this->fileHandler->read();
	}

	public function write($value, $force = true) {
		return $this->fileHandler->write($value, $force);
	}

	public function delete() {
		return $this->fileHandler->delete();
	}
}