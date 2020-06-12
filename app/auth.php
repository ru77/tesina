<?php namespace AuthManager;

class Auth extends Mvc\AbstractService{

  private $_authorized_user;

  public function __construct(){
      parent::__construct();
  }

  public function auth($form){
    $stmt = parent::$_db->prepare("SELECT * FROM Users WHERE email = :email AND password = :password");
    if($stmt->execute(['email' => $form["email"], 'password' => $form["password"]])){
      $row = $stmt->fetch();
      $this->_authorized_user = UsersManager\FactoryUser::getUser($DB_OBJ);
      $this->user_session();
      return $user->get_id();
    }else return 0;
  }

  public function registration($form){
    $this->_authorized_user = UsersManager\FactoryUser::insertUser($form);
    if($this->_authorized_user){
      $this->user_session();
      return true;
    }else{
      return false;
    }
  }

  private function user_session(){
    session_start();
    if(isset($_SESSION['user_obj'])) $_SESSION['user_obj'] = null;
    if(isset($_SESSION['user_id'])) $_SESSION['user_id'] = 0;
    $_SESSION['user_obj'] = $this->_authorized_user;
    $_SESSION['user_id'] = $this->_authorized_user->get_id();
  }

}
 ?>
