<?php class ProductsController {

	function index () {

		Views::render('products/index', get_defined_vars());
	}

	function new () {

		Views::render('products/new', get_defined_vars());
	}

	function edit () {

		Views::render('products/edit', get_defined_vars());
	}

	function create () {

		Views::render('products/create', get_defined_vars());
	}

	function show ($slug) {

		Views::render('products/show', get_defined_vars());
	}

	function update ($slug) {

		Views::render('products/update', get_defined_vars());
	}

	function destroy ($slug) {

		Views::render('products/destroy', get_defined_vars());
	}

}