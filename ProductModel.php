<?php class ProductModel extends Model {

  static public $table = "products";

  public $id;
  public $name;

  protected static $permited_params = ['name'];

}