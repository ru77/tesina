<?php
require 'DatabaseManager.php';
class Auth{
  private $_db;

  public function __construct(){
      $this->_db = (new DatabaseManager())->getInstance();
  }

  function getTable($pdo)
  {
    var_dump($pdo);
    $stmt = $pdo->query("SELECT * FROM Users");
    $table = [];
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) { $table[] = $row;  }
    return $table;
  }

  function getForm()
  {
    if($_POST['type']=="admin")
    {
      $type = 1;
    }else
    {
      $type = 0 ;
    }
    return $form = ['email'=>$_POST["email"],'password' => $_POST['password'], 'type' => $type];
  }

  public function insert($user){
    $cmd = 'INSERT INTO Users(email,password,type) VALUES(:email,:password,:type)';
    $stmt = $this->_db->prepare($cmd);
    $stmt->bindValue(':email', $user['email']);
    $stmt->bindValue(':password', $user['password']);
    $stmt->bindValue(':type', $user['type']);
    $stmt->execute();
  }

  function check($pdo,$form)
  {
    $pdo->exec("USE Credentials");
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = :username AND password = :password");
    return $stmt->execute(['username' => $form["username"], 'password' => $form["password"]]);
  }
  function checkType($pdo,$form)
  {
    $stmt = $pdo->prepare("SELECT type FROM Users WHERE username = :username");
    $stmt->execute(['username' => $form["username"]]);
    return $name = $stmt->fetchColumn();
  }
  function usernames($pdo)
  {
    return $pdo->query("SELECT username FROM Users");
  }
  function userpasswds($pdo)
  {
    return $pdo->query('SELECT username FROM Users');
  }
}
 ?>
