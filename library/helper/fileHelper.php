<?php
class fileHelper extends \Coal\Core\helper {
	private $fileHandler = null;

	public function __construct() {

	}

	public function load($file) {
		$this->fileHandler = new \Coal\Core\file($file);
	}

	public function exists() {
		if ($this->fileHandler)
			return $this->fileHandler->exists();
	}

	public function read() {
		if ($this->fileHandler)
			return $this->fileHandler->read();
	}

	public function write($value, $force = true) {
		if ($this->fileHandler)
			return $this->fileHandler->write($value, $force);
	}

	public function delete() {
		if ($this->fileHandler)
			return $this->fileHandler->delete();
	}
}