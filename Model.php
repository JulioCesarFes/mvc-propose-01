<?php class Model {

  static function all () {
    $table = static::$table;
    $query = "SELECT * FROM $table;";

    return  $query;
  }
  
}