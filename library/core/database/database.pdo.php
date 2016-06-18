<?php
namespace Coal\Core;

class databasePDO {
	private $sqlHandler = null;

	public function __construct() {
	}

	public function connect($database) {
		try {
			$this->sqlHandler = new PDO('mysql:host='.$database->host.';dbname='.$database->name, $database->username, $database->password);
		} catch (PDOException $e) {
			return false;
		}

		return true;
	}

	public function disconnect() {
		$this->sqlHandler = null;
	}

	public function query() {
		$args = func_get_args();
		$query = array_shift($args);

		try {
			$this->sqlHandler->prepare($query);

			foreach ($args as $vars)
			{
				foreach ($vars as $key => $value) {
					$this->sqlHandler->bindParam($key, $value);
				}
				$this->sqlHandler->execute();
			}
		} catch (PDOException $e) {
			return false;
		}

		return true;
	}
}
