<?php
final class Dispatcher{

  private $_request;
  private $_param;
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
  }

  private function switch(){
    $page = false;
    switch($this->_request){
      case "dashboard":
      case "home":
        $page = ["HomePage"];
        break;
      case "login":
        $page = ["LoginPage"];
        break;
      case "signup":
        $page = ["SignUpPage"];
        break;
      case "request": break;
      case "view":
        $page = ["ViewPage"];
        break;
      case "search": break;
      case "download": break;
      case "js":
        $this->handleJavaScriptResource();
        break;
      default:
        $page = ["ErrorPage"];
        break;
    }
    System::get_builder_lib();
    System::get_pages_lib();
    if($page){
      $this->_builder = new FrontEndBuilder\Builder($page[0]);
      $this->_builder->build();
    }else{
      $this->_builder = new FrontEndBuilder\Builder(false);
      $this->_builder->buildHeader();
    }
  }

  private function handleJavaScriptResource(){
    System::get_command_interface();
    switch($this->_param){
      case "auth":
        System::get_auth_command();
        break;
      case "register":
        System::get_register_command();
        break;
    }
  }

  private function error(){

  }
}
$dispatcher = new Dispatcher();
?>
