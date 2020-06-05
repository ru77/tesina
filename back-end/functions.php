<<?php

function connectionDB()
{
  $host="127.0.0.1";
  $user="root";
  $passw="";
  $db="Credentials";
  $options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ];
  $mydb = new PDO("mysql:host=$host;charset=utf8mb4", $user, $passw, $options);
    $mydb->exec("CREATE DATABASE IF NOT EXISTS `$db`;
                CREATE USER '$user'@'localhost' IDENTIFIED BY '$passw';
                GRANT ALL ON `$db`.* TO '$user'@'localhost';
                FLUSH PRIVILEGES;")
    or die(print_r($mydb->errorInfo(), true));
  return $mydb;
}
function createTables($pdo)
{
  $cmd = 'CREATE TABLE IF NOT EXISTS Users(
                                          id INT NOT NULL AUTO_INCREMENT,
                                          email VARCHAR(50) NOT NULL,
                                          password VARCHAR(10) NOT NULL,
                                          PRIMARY KEY ( id )
                                            )';
  $cmd2 = 'USE Credentials;';
  $pdo->exec($cmd2);
  $pdo->exec($cmd);
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
  return $form = ['username'=>$_POST["username"],'password' => $_POST['password']];
}
function insert($pdo,$form)
{
  $cmd = 'INSERT INTO Users(username,password,type) VALUES(:username,:password)';
  $stmt = $pdo->prepare($cmd);
  $stmt->bindValue(':username', $form['username']);
  $stmt->bindValue(':password', $form['password']);
  $stmt->execute();
}
function checkCredentials($pdo,$form)
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
?>
