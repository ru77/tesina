<?php namespace AuthManager;

class SessionManager{

  public function __construct(){
      session_start();
  }

  public function check_user_session(){
    if (isset($_SESSION['user_obj'])) return true;
    else return false;
  }

  public function get_user_id(){
    if(isset($_SESSION['user_id'])) {return $_SESSION['user_id'];}
    else return false;
  }

  public function destroy_user_session(){
    session_destroy();
  }

  public function debug(){
    print_r($_SESSION['user_obj']);
  }

  public function get_name(){
    if(isset($_SESSION['user_name'])) {
      return $_SESSION['user_name'];
    }else return false;
  }

  public function create_user_session($_authorized_user){
    $_SESSION['user_obj'] = $_authorized_user;
    $_SESSION['user_name'] = $_authorized_user->get_username();
    $_SESSION['user_id'] = $_authorized_user->get_id();
  }

}
$GLOBALS['session_handler'] = new SessionManager();
 ?>
