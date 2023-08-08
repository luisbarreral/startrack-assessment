<?php
class MyDB
{
  private $file_db;
  public $last_error = null;
  const DATABASE = "libs/database/startrack.sqlite3";
  function __construct()
  {
    try {
      $this->file_db = new PDO("sqlite:" . self::DATABASE);
    } catch (PDOException $e) {
      $this->last_error = $e->getMessage();
    }
  }

  function exec($query)
  {
    $this->last_error = null;
    $rows_afected = 0;
    try {
      $rows_afected = $this->file_db->exec($query);
    } catch (PDOException $e) {
      $this->last_error = $e->getMessage();
      $rows_afected = 0;
    }
    return $rows_afected;
  }

  function query($query)
  {
    $this->last_error = null;
    try {
      $stmt = $this->file_db->query($query);
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $this->last_error = $e->getMessage();
    }
  }
}
?>