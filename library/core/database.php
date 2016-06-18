<?php
namespace Coal\Core;

class database {
	private $sqlHandler = null;
	private $database = null;

	public function __construct($database_name = 'default') {
		$databases = settings::get('databases');
		if (!$databases) throw new databaseException('No databases found', 404);

		if (!isset($databases[$database_name])) throw new databaseException('Database not found', 404);

		$this->database = $databases[$database_name];

		$driver = $this->database->driver;

		$file = CORE.'database'.DS.'database.'.strtolower($driver).'.php';
		if (file_exists($file))
			require_once($file);

		$database_driver_name = '\\Coal\\Core\\database_'.$driver;
		if (!class_exists($database_driver_name))
			throw new cacheErrorException('No sqlHandler found', 404);

		$this->sqlHandler = new $database_driver();

		$this->connect();
	}

	public function connect() {
		$this->sqlHandler->connect($this->database);
	}

	public function disconnect() {
		$this->sqlHandler->disconnect();
	}

	public function query() {
		$output = call_user_func_array([$this->sqlHandler, 'query'], func_get_args());

		if (!$output) {
			$args = func_get_args();
			$query = array_shift($args);
			throw new databaseException('An error occured with your query: "'.$query.'"', 500);
		}
	}

	public function __destruct() {
		$this->sqlHandler->disconnect();
	}
}

class databaseException extends errorException {

}