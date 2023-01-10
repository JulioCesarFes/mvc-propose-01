<?php class Views {

	static function render ($filepath, $arguments) {

		extract($arguments);
		require_once $filepath . '.html.php';

	}

	static function redirect ($path) {
		header("Location: $path");
	}
	
}