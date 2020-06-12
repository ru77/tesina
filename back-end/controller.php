<?php
require_once 'Auth.php';
require_once 'TransferFiles.php'
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
class Controller{

  public static function user_registration_procedure($USER_INFO){
    $auth = new Auth();
    //$code = ($auth->insert($USER_INFO) ? 200 : 404); // TERNAR OPERATOR: ([CONDITION] ? true : false);
    if($auth->insert($USER_INFO)){
      // authetication
      http_response_code(200);
    }else echo "Fail, user already in";
  }
  public static function user_authentication_procedure($USER_INFO){
    $auth = new Auth();
    $USER_ID = $auth->check($USER_INFO);
    $USERNAME = $auth->;
    if($USER_ID > 0){
      http_response_code(200);
      session_start();
      $_SESSION["user_id"] = $USER_ID;
      $_SESSION["username"] = $USERNAME;
    }else{
      http_response_code(404);
    }
  }
  public static function uploadFile($_FILES){
    $tf = new TransferFiles($USER,$_FILES);
    if ($tf->upload()==true) http_response_code(200);
    else http_response_code(404);
  }
  public static function downloadFile(){

  }
}

/*
CALLS
*/
if (isset($_POST['registration'])){
  $form = array('email' => $_POST["email"], 'password' => $_POST['password']);
  Controller::user_registration_procedure($form);
  flush();
}
if (isset($_POST['auth'])) {
  $form = array('email' => $_POST["email"], 'password' => $_POST['password']);
  Controller::user_authentication_procedure($form);
  flush();
}
if (isset($_POST['upload'])) {
  if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload'){
    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
      Controller::uploadFile($_FILES);
      flush();
    }
  }
}

?>
