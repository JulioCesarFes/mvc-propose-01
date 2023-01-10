<?php class Model {

  static function all () {
    $table = static::$table;
    $query = "SELECT * FROM $table;";

    return self::convertResult(self::instance()->query($query));
  }

  static function where ($where, $params) {
    $table = static::$table;
    
    $query = "SELECT * FROM $table WHERE $where;";

    $stmt = self::instance()->prepare($query);

    $s = str_repeat('s', count($params));

    $stmt->bind_param($s, ...$params);

    $stmt->execute();

    return self::convertResult($stmt->get_result());
  }

  function update ($params) {
    $filterParams = self::filterParams($params);

    $query = self::buildUpdateQuery($filterParams);

    $stmt = self::instance()->prepare($query);

    $s = str_repeat('s', count(array_keys($filterParams)) + 1);

    $stmt->bind_param($s, ...array_merge(array_values($filterParams), [$this->id]));

    $stmt->execute();
  }

  static function new ($params) {
    $filterParams = self::filterParams($params);

    $query = self::buildInsertQuery($filterParams);

    $stmt = self::instance()->prepare($query);

    $s = str_repeat('s', count(array_keys($filterParams)));

    $stmt->bind_param($s, ...array_values($filterParams));

    $stmt->execute();
  }

  static function destroy ($id) {
    $table = static::$table;
    $query = "DELETE FROM $table WHERE id = $id;";
    self::instance()->query($query);
  }

  static function find ($id) {
    $table = static::$table;
    $query = "SELECT * FROM $table WHERE id = $id;";
    return self::convertSingleResult(self::instance()->query($query));
  }

  # other functions

  static function filterParams ($params) {
    $permited = array_flip(static::$permited_params);
    return array_intersect_key($params, $permited);
  }

  static function buildInsertQuery ($filterParams) {
    $table = static::$table;
    $keys = array_keys($filterParams);

    $columns = implode(", ", $keys);
    $interrogations = implode(", ", array_fill(0, count($keys), "?"));

    return "INSERT INTO $table ($columns) VALUES ($interrogations);";
  }

  static function buildUpdateQuery ($filterParams) {
    $table = static::$table;
    $keys = array_keys($filterParams);

    $columns = [];

    foreach ($keys as $key) {
      $columns[] = "$key = ?";
    }

    $columns = implode(', ', $columns);

    return "UPDATE $table SET $columns WHERE id = ?;";
  }


  # mysqli connect and friends

  static private $instance = null;

  static private function instance () {

    if (self::$instance == null) {
      self::$instance = new mysqli(HOST, USER, PASS, BASE);
      self::$instance->set_charset('utf8mb4');

      if (self::$instance->connect_error) die('Connect Error (' . self::$instance->connect_errno . ') ' . self::$instance->connect_error);
    }

    return self::$instance;
  }

  static function convertResult ($result) {
    $response = [];
    
    while ($row = $result->fetch_assoc()) {

      $instance = new static();

      foreach($row as $attribute => $value){
        $instance->$attribute = $value;
      }

      $response[] = $instance;

    }

    return $response;
  }

  static function convertSingleResult ($result) {
    $row = $result->fetch_assoc();

    $instance = new static();

    foreach($row as $attribute => $value){
      $instance->$attribute = $value;
    }

    return $instance;
  }
  
}