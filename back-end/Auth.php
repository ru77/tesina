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
    return $form = ['email'=>$_POST["email"],'password' => $_POST['password']];
  }

  public function insert($user){
    $cmd = 'INSERT INTO Users(email,password) VALUES(:email,:password)';
    $stmt = $this->_db->prepare($cmd);
    $stmt->bindValue(':email', $user['email']);
    $stmt->bindValue(':password', $user['password']);
    $stmt->execute();
  }

  function check($pdo,$form)
  {
    $pdo->exec("USE Credentials");
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = :username AND password = :password");
    return $stmt->execute(['username' => $form["username"], 'password' => $form["password"]]);
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
