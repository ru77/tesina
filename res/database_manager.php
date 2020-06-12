<?php
class DatabaseManager{
  private $_host = "127.0.0.1";
  private $_user = "user";
  private $_passw = "";
  private $_db = "Credentials";

  private $_dbAccess;

  public function __construct(){
    $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $this->_dbAccess = new PDO("mysql:host=$this->_host;charset=utf8mb4", $this->_user, $this->_passw, $options);
    $this->_dbAccess->exec("USE Credentials");
  }

  public function getInstance(){
    return $this->_dbAccess;
  }

  public function writeDB(){
    $this->_dbAccess->exec("CREATE DATABASE IF NOT EXISTS `$this->_db`;
      CREATE USER '$this->_user'@'localhost' IDENTIFIED BY '$this->_passw';
      GRANT ALL ON `$this->_db`.* TO '$this->_user'@'localhost';
      FLUSH PRIVILEGES;");
    $cmd = 'CREATE TABLE IF NOT EXISTS Users(
      id INT NOT NULL AUTO_INCREMENT,
      email VARCHAR(30) NOT NULL,
      password VARCHAR(20) NOT NULL,
      type INT(1) NOT NULL,
      PRIMARY KEY ( id )
    )';
    $cmd2 = 'USE Credentials;';
    $this->_dbAccess->exec($cmd2);
    $this->_dbAccess->exec($cmd);
  }
}

?>
