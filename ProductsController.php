<?php class ProductsController {

	function index () {

		$products = ProductModel::all();
		echo $products;
		echo '<br>';

		$cart = CartModel::all();
		echo $cart;
		echo '<br>';

		Views::render('products.index', get_defined_vars());
	}

}