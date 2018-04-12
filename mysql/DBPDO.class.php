<?php

class DBPDO {

  protected $drive = 'mysql';
  protected $hostname = '';
  protected $username = '';
  protected $password = '';
  protected $database = '';
  protected $charset = 'utf8';
  protected $link = '';
  protected $db = '';

  public function __construct () {
    $this->link = "{$this->drive}:host={$this->hostname};dbname={$this->database};charset={$this->charset}";
    $this->db = $this->db_connection();
  }

  public function db_connection () {
    try {
      $conn = new PDO($this->link, $this->username, $this->password, array(
        PDO::ATTR_PERSISTENT => true
      ));

      return $conn;
    } catch (PDOException $e) {
      die('Could not connect to server:' . $e->getMessage());
    }
  }

  public function db_insert () {

  }

  public function db_delete () {

  }

  public function db_update () {

  }

  public function db_query () {

  }

}