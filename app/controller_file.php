<?php namespace FileManager;

final class ControllerFile extends \Mvc\AbstractController{

  public function __construct($REQUEST, $DATA){
    parent::__construct($REQUEST, $DATA);
  }

  public function upload($FILE){
    session_start();
    if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
      $eval = FactoryFile::uploadFile($FILE, $user_id);
      if($eval){
        http_response_code(200);
      }
    }else http_response_code(404);
    return $eval;
  }

  /*+ ControllerFile(request:String, data:Object[])
  + upload(Object[]): boolean
  + delete(user_id:int, name:String): boolean
  + move(String destination):boolean
  + rename(String new_name):boolean
  + copy(String destination):boolean
  + clone():boolean */
}
?>
