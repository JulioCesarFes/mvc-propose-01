<?php class View {

	static function render ($filepath, $arguments) {

		extract($arguments);
		require_once $filepath . '.html.php';

	}
	
}