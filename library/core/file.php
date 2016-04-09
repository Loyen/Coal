<?php
namespace Coal\Core;

class file {
	public $file = null;

	public function __construct($file = null) {
		$this->file = $file;
	}

	public function exists() {
		return file_exists($this->file);
	}

	public function read() {
		if ($this->exists($this->file)) {
			if ($content = file_get_contents($this->file)) {
				return $content;
			}
		}

		return false;
	}

	public function write($value, $force = true) {
		if (!$this->exists($this->file) || $force) {
			if (is_string($value) && file_put_contents($this->file, $value, LOCK_EX))
				return true;
		}

		return false;
	}

	public function delete() {
		if ($this->exists($this->file)) {
			if (unlink($this->file)) {
				return true;
			}
		}

		return false;
	}
}