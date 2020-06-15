<?php
final class Dispatcher{

  private $_request;
  private $_param;
  private $_target_request;
  private $_builder;
  private static $_prefix;

  //Dispatcher::$_prefix = 0; //eseguito al caricamento del file
  function __construct(){
    if(isset($_GET['request'])){
        $this->_request = $_GET['request'];
        if(isset($_GET['param'])) $this->_param = $_GET["param"];
        Dispatcher::$_prefix = ( isset($_GET['prefix']) ? $_GET['prefix'] : "./" );
        $this->init();
        $this->switch();
    }else $this->error();
  }

  private function init(){
    require_once("system.php");
    System::init();
    System::get_database_lib();
    System::get_model();
    System::get_service();
    System::get_controller();
    System::get_user_lib();
    System::get_session_lib();
  }

  private function switch(){
    $page = false;
    switch($this->_request){
      case "dashboard":
      case "home":
        $page = ["HomePage", false];
        break;
      case "login":
        $page = ["LoginPage", false];
        break;
      case "signup":
        $page = ["SignUpPage", false];
        break;
      case "request":
        $this->handleRequest();
        break;
      case "view":
        $page = ["ViewPage", true];
        break;
      case "search":
        break;
      case "download":
        break;
      case "js":
        $this->handleJavaScriptResource();
        break;
      default:
        $page = ["ErrorPage", false];
        break;
    }
    System::get_builder_lib();
    System::get_pages_lib();
    if($page){
      $this->_builder = new FrontEndBuilder\Builder($page);
      $this->_builder->build();
    }else{
      $this->_builder = new FrontEndBuilder\Builder(false);
      $this->_builder->buildHeader($this->_request);
    }
  }

  private function userHandler($request){
    $auth_manager = null;
    System::get_auth_lib();
    $auth_manager = new AuthManager\Auth();
    switch($this->_target_request){
      case "register":
      $auth_manager->register($_POST["payload"], true);
      break;
      case "auth":
      $auth_manager->auth($_POST["payload"], true);
      break;
      case "deauth":
      $auth_manager->deauth();
      $this->login("../");
      break;
    }
  }

  private function fileHandler($request){
    System::get_file_lib();
    System::get_file_controller();
    $file_controller = new FileManager\ControllerFile();
    switch($this->_target_request){
      case "upload":
        $file_controller->upload($_POST["payload"]);
        break;
      case "explorer":
        $file_controller->print($_POST["payload"]);
        break;
    }

  }

  private function handleRequest(){
    $this->_target_request = $_POST["target"];
    if($this->_param == "deauth") $this->_target_request = $this->_param;
    switch($this->_target_request){
      case "register":
      case "auth":
      case "deauth":
        $this->userHandler($this->_target_request);
        return;
      case "upload":
      case "explorer":
        $this->fileHandler($this->_target_request);
        return;
    }
  }

  private function handleJavaScriptResource(){
    switch($this->_param){
      case "auth":
        System::get_auth_command();
        break;
      case "register":
        System::get_register_command();
        break;
      case "upload":
        System::get_upload_command();
        break;
      case 'command':
        System::get_command_interface();
        break;
      case 'explorer':
        System::get_explorer_command();
        break;
    }
  }

  private function error(){ $this->redirect("error"); }

  private function redirect($url){ header("location: ".$this->_prefix . $url, 301); }

  private function home($prefix = "./"){$this->redirect($prefix . "dashboard");}

  private function login($prefix = "./"){$this->redirect($prefix . "login");}
}
$DISPATCHER = new Dispatcher();
?>
