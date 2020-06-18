<?php namespace AuthManager;
use Mvc\AbstractService as MVC_AbstractService;
use UsersManager\FactoryUser as USER_Factory;
class Auth extends MVC_AbstractService{

  private $_authorized_user;

  public function __construct(){
      parent::__construct();
  }

  public function auth($form, $http_response_flag = false){
    if(isset($form['check'])){
        if($GLOBALS['session_handler']->check_user_session()){
          http_response_code(200);
        }else http_response_code(404);
        return;
    }
    $stmt = parent::$_db->prepare("SELECT * FROM Users WHERE email = :email AND password = :password");
    if($stmt->execute(['email' => $form["email"], 'password' => $form["psw"]])){
      $row = $stmt->fetch();
      if ($row==null){http_response_code(404);}
      else {
        $this->_authorized_user = USER_Factory::getUser($row);
        $GLOBALS['session_handler']->create_user_session($this->_authorized_user);
      }
    }else{
      $this->_authorized_user = null;
      throw new Error("Auth class unable to establish a database connection");
    }
    if($http_response_flag){
      if($this->_authorized_user){
        http_response_code(200);
        echo $this->_authorized_user->get_id();
      }else http_response_code(404);
    }else return ($this->_authorized_user->get_id() || 0);
  }

  public function register($form, $http_response_flag = false){
    $this->_authorized_user = USER_Factory::insertUser($form);
    if($this->_authorized_user){
      $GLOBALS['session_handler']->create_user_session($this->_authorized_user);
      if($http_response_flag) http_response_code(200);
      return true;
    }else{
      if($http_response_flag) http_response_code(404);
      return false;
    }
  }

  public function deauth(){
    $GLOBALS['session_handler']->destroy_user_session();
  }

  function get($ID){}
  function delete($ID){}
  function insert($OBJ){}
  function list($FILTERS){}
}
 ?>
