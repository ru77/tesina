<?php
class DatabaseManager{
  private const $_host = "127.0.0.1";
  private const $_user = "root";
  private const $_passw = "";
  private const $_db = "Credentials";

  private $_dbAccess;

  public __construct(){
    $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $this->_dbAccess = new PDO("mysql:host=$this->_host;charset=utf8mb4", $this->_user, $this->_passw, $options);
  }

  public function getInstance(){
    return $this->_dbAccess;
  }

  public function writeDb(){
    $this->_dbAccess->exec("CREATE DATABASE IF NOT EXISTS `$this->_db`;
      CREATE USER '$this->_user'@'localhost' IDENTIFIED BY '$this->_passw';
      GRANT ALL ON `$this->_db`.* TO '$this->_user'@'localhost';
      FLUSH PRIVILEGES;")
    $cmd = 'CREATE TABLE IF NOT EXISTS Users(
      or die(print_r($this->_db->errorInfo(), true));
      id INT NOT NULL AUTO_INCREMENT,
      username VARCHAR(10) NOT NULL,
      password VARCHAR(10) NOT NULL,
      type INT(1) NOT NULL,
      PRIMARY KEY ( id )
    )';
    $cmd2 = 'USE Credentials;';
    $this->_dbAccess->exec($cmd2);
    $this->_dbAccess->exec($cmd);
  }
}

?>
