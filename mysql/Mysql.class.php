<?php
namespace DB;

class Mysql {

  protected $drive = '';
  protected $hostname = '';
  protected $username = '';
  protected $password = '';
  protected $database = '';
  protected $charset = '';
  protected $link;
  protected $db;

  public function __construct () {
    $this->link = $this->drive . ":host=";
    $this->link .= $this->hostname . ";dbname=";
    $this->link .= $this->database . ";charset=";
    $this->link .= $this->charset;
    $this->db_connection();
  }

  public function db_connection () {
    try {
      $this->db = new \PDO($this->link, $this->username, $this->password, array(
        \PDO::ATTR_PERSISTENT => true
      ));
      return true;
    } catch (\PDOException $e) {
      die('Could not connect to server:' . $e->getMessage() . "\n");
    }
  }

  /**
   * 添加数据
   * @param $table string 数据表名称
   * @param $param array  添加的数据
   * @return mixed
   *
   * 用法说明：
   * $table = 'users';
   * $data = array('name'=>'benly-tools-php','email'=>'ex@...');
   * $mysql = new DB\Mysql();
   * $mysql->db_insert($table, $data);
   */
  public function db_insert ($table, $param) {
    $field = array();
    $value = array();

    foreach ($param as $k => $v) {
      $field[] = "`{$k}`";
      $value[] = "'{$v}'";
    }
    $field = implode(',', $field);
    $value = implode(',', $value);
    $result = $this->db->query("INSERT INTO {$table} ({$field}) VALUE ({$value})");

    return $result;
  }

  /**
   * 删除数据
   * @param $table string 数据表名
   * @param string $where 删除条件
   * @return mixed
   *
   * 用法说明：
   * 1.
   * $table = 'users';
   * $where = array('name'=>'benly-tools-php','email'=>'ex@...');
   * $mysql = new DB\Mysql();
   * $mysql->db_delete($table, $where);
   * 2.
   * $table = 'users';
   * $where = "name=benly-tools-php AND email=ex@...";
   * $mysql = new DB\Mysql();
   * $mysql->db_delete($table, $where);
   */
  public function db_delete ($table, $where = '') {
    if (is_array($where)) {
      $whereArr = array();
      foreach ($where as $k => $v) {
        $whereArr[] = "`{$k}`={$v}";
      }
      $where = implode(' AND ', $whereArr);
    }

    return $this->db->query("DELETE FROM {$table} WHERE {$where}");
  }

  /**
   * 更新数据
   * @param $table string 数据表名
   * @param string $field 更新字段
   * @param string $where 更新条件
   * @return mixed
   *
   * 使用说明：
   * 1.
   * $table = 'users';
   * $field = array('name','email');
   * $where = array('name'=>'benly-tools-php','email'=>'ex@...');
   * $mysql = new DB\Mysql();
   * $mysql->db_update($table, $field, $where);
   * 2.
   * $table = 'users';
   * $field = 'name,email';
   * $where = "name=benly-tools-php AND email=ex@...";
   * $mysql = new DB\Mysql();
   * $mysql->db_update($table, $field, $where);
   */
  public function db_update ($table, $field = '', $where = '') {
    if (is_array($where)) {
      $whereArr = array();
      foreach ($where as $k => $v) {
        $whereArr[] = "`{$k}`={$v}";
      }
      $where = implode(' AND ', $whereArr);
    }
    $fieldArr = array();
    foreach($field as $k => $v) {
      $fieldArr[] = "`{$k}`='{$v}'";
    }
    $field = implode(',',$fieldArr);
    if (empty($where)) {
      $sql = "UPDATE {$table}  SET {$field}";
    } else {
      $sql = "UPDATE {$table}  SET {$field} WHERE {$where}";
    }
    return $this->db->query($sql)->rowCount();
  }

  /**
   * 查询数据
   * @param $table string 数据表名
   * @param string $field 查询字段
   * @param string $where 查询条件
   * @param string $order 查询排序
   * @param string $limit 查询条数
   * @return mixed
   *
   * 使用说明：
   * 1.
   * $table = 'users';
   * $field = array('name','email');
   * $where = array('name'=>'benly-tools-php','email'=>'ex@...');
   * $order = 'id DESC'; 非必需
   * $limit = array(0,10); 非必需
   * $mysql = new DB\Mysql();
   * $mysql->db_query($table, $field, $where, $order, $limit);
   * 2.
   * $table = 'users';
   * $field = 'name,email';
   * $where = "name=benly-tools-php AND email=ex@...";
   * $order = 'id DESC'; 非必需
   * $limit = '0,10'; 非必需
   * $mysql = new DB\Mysql();
   * $mysql->db_query($table, $field, $where, $order, $limit);
   */
  public function db_query ($table, $field = '', $where = '', $order = '', $limit = '') {
    if (is_array($field)) {
      $field = implode(',', $field);
    }
    if (empty($field)) {
      $field = '*';
    }
    if (is_array($where)) {
      foreach ($where as $k => $v) {
        $where[] = "`{$k}`={$v}";
      }
      $where = implode(' AND ', $where);
    }
    if (is_array($limit) && !empty($limit)) {
      $limit = implode(',', $limit);
    }
    if (!empty($order) && empty($limit)) {
      $sql = "SELECT {$field} FROM {$table} WHERE {$where} ORDER BY {$order}";
    } elseif(!empty($limit) && empty($order)) {
      $sql = "SELECT {$field} FROM {$table} WHERE {$where} LIMIT {$limit}";
    } elseif (!empty($limit) && !empty($order)) {
      $sql = "SELECT {$field} FROM {$table} WHERE {$where} ORDER BY {$order} LIMIT {$limit}";
    } elseif (empty($where)) {
      $sql = "SELECT {$field} FROM {$table}";
    } else {
      $sql = "SELECT {$field} FROM {$table} WHERE {$where}";
    }

    return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
  }
}