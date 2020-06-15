<?php namespace FileManager;

final class ControllerFile extends \Mvc\AbstractController{

  public function __construct(){
    parent::__construct();
  }

  private function get_user_id(){
    if($GLOBALS['session_handler']->check_user_session()){
      return $GLOBALS['session_handler']->get_user_id();
    }else return false;
  }
  public function upload($FILE){
    $eval = false;
    $id = $this->get_user_id();
    if($id){
      $eval = FactoryFile::uploadFile($FILE, $id);
      if($eval){
        http_response_code(200);
      }
    }else http_response_code(404);
    return $eval;
  }

  public function list($FILTERS){
    $id = $this->get_user_id();
    if($id){
      return FactoryFile::getUserFiles($id);
    }else http_response_code(404);
  }

  public function print($FILTERS){
    $files = $this->list($FILTERS);
    FactoryFile::explorer($files);
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
