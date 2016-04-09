<?php
namespace Coal\Core;

class renderer {
	public function parse_file($_file, $_vars = []) {
		$_output = '';
		if (file_exists($_file)) {
			ob_start();
			extract($_vars);
			include($_file);
			$_output = ob_get_contents();
			ob_end_clean();
		}

		return $_output;
	}
}