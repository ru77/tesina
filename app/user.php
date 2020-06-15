<?php
namespace UsersManager;

final class FactoryUser{
  public final static function getUser($DB_OBJ){
    $user;
    if(isset($DB_OBJ['type']) && $DB_OBJ['type'] == 1) {
      $user = new Admin($DB_OBJ);
    }else {
      $user = new User($DB_OBJ);
    }
    return $user;
  }

  public final static function copyUser($User){
    return User::copy_constructor($User);
  }

  public final static function insertUser($user_fe){
    $user = FactoryUser::createUser($user_fe);
    $service = new ServiceUser();
    $user_obj = $service->insert($user);
    return $user_obj;
  }

  public final static function createUser($user_obj){
    $obj = array("email" => $user_obj['email'], "username" => explode('@', $user_obj['email'])[0], "id" => 0, "type" => 0, "password" => $user_obj['psw']);
    return FactoryUser::getUser($obj);
  }
}

class User{
  private $_email;
  private $_user_id;
  private $_psw;
  private $_super = false;

  public function __construct($DB_OBJ){
    if(isset($DB_OBJ['username'])) $this->set_username($DB_OBJ['username']);
    if(isset($DB_OBJ['email'])) $this->set_email($DB_OBJ['email']);
    if(isset($DB_OBJ['password'])) $this->set_psw($DB_OBJ['password']);
    if(isset($DB_OBJ['id'])) $this->_user_id = $DB_OBJ['id'];
  }

  public static function copy_constructor($User){
    $obj = new User(array("id" => 0));
    $obj->set_id($User->get_id());
    $obj->set_username($User->get_username());
    $obj->set_email($User->get_email());
    if($User instanceof Admin) return Admin::build_by_user($obj);
    if($User instanceof User) return $obj;
  }

  public function set_email($emailaddress){
    $this->_email = $emailaddress;
  }

  public function set_username($username){  $this->_username = $username; }
  public function set_id($id){  $this->_user_id = $id; }
  public function set_psw($psw){  $this->_psw = $psw; }

  public function get_username(){
    return explode("@", $this->_email)[0];
  }
  public function get_id(){ return $this->_user_id; }
  public function get_email(){  return $this->_email; }
  public function get_type(){ return ($this->_super ? 1 : 0); }
  public function get_psw(){  return $this->_psw; }
}

final class Admin extends User{
  private $_super = true;

  public function __construct($DB_OBJ){
    parent::__construct($DB_OBJ);
  }
  public static function build_by_user($User){
    $obj = new Admin(array("id" => 0));
    $obj->set_id($User->get_id());
    $obj->set_username($User->get_username());
    $obj->set_email($User->get_email());
    return $obj;
  }


}

use Mvc\AbstractService as MVC_AbstractService;
class ServiceUser extends MVC_AbstractService{
  private $_user = null;

  public function __construct(){ parent::__construct(); }

  public function get($user_id){
    $query = "SELECT * FROM Users WHERE id = ?";
    $stmt = parent::$_db->prepare($query);
    $stmt->bindParam($user_id);
    if($stmt->execute()){
      $this->_user = FactoryUser::getUser($stmt->fetch());
    }
    return $this->_user;
  }

  public function delete($user_id){}

  public function insert($user){
    $cmd = 'INSERT INTO Users(username,email,password,type) VALUES(:username,:email,:password,:type)';
    $stmt = parent::$_db->prepare($cmd);
    $stmt->bindValue(':username', $user->get_username());
    $stmt->bindValue(':email', $user->get_email());
    $stmt->bindValue(':password', $user->get_psw());
    $stmt->bindValue(':type', $user->get_type());
    if($stmt->execute()){
      $id = parent::$_db->lastInsertId();
      $user->set_id($id);
      return $user;
    }else return false;
  }

  public function list($filters){}
}
?>
