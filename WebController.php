<?php class WebController {

	function index () {
		Views::render('web.index', get_defined_vars());
	}
}