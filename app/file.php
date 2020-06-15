<?php namespace FileManager;

final class FactoryFile{
  public static final function uploadFile($file, $user_id){
    echo "Hello";
    $file = new UploadedFile($file);
    return $file->write($user_id);
  }

  public static final function explorer($concreteFiles){
    ?><div class="row"><?php
    foreach($concreteFiles as $file){
      ?>
      <div class="col s6 m4 l3">
        <div class="card" style="min-height: 250px;max-height: 250px;">
          <div class="card-image grey lighten-4 center">
            <i class="large material-icons <?=$file->get_color_preview();?>" style="padding: 30px 0;"><?=$file->get_icon_preview();?></i>
            <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">more_vert</i></a>
          </div>
          <div class="card-content">
            <span class="card-title black-text truncate"><?=$file->get_name();?></span>
          </div>
        </div>
      </div>
      <?php
    }
    ?></div><?php
  }

  public static function get_files_path(){
    return \System::get_abs()."_files/";
  }

  public static function get_file_extension($filename){
    $fileNameCmps = explode(".", $filename);
    return strtolower(end($fileNameCmps));
  }

  public static final function getUserFiles($id){
    $files = scandir(self::get_files_path().$id);
    $files_obj = array();
    foreach(array_slice($files, 2) as $file){
      $concrete_file = new ConcreteFile($file, $id);
      $files_obj[] = $concrete_file->build();
    }
    return $files_obj;
  }


}

abstract class AbstractFile{
  protected $_name;
  protected $_date;
  protected $_extension;
  protected $_size;
  protected $_path;
  protected $_user_id;

  protected function __construct($NAME, $id = false){
    $this->_name = $NAME;
  }


  protected function get_user_dir_path($_user_id){
    $this->_path = FactoryFile::get_files_path();
    $this->_path .= $_user_id;
    return $this->_path;
  }

  protected function get_extension(){
    $this->_extension = FactoryFile::get_file_extension($this->_name);
    return $this->_extension;
  }


  protected function set_user_id($id){
    $this->_user_id = $id;
  }

}

final class UploadedFile extends AbstractFile{
  private $_data;

  public function __construct($FILE){
    $this->_name = $FILE['filename'];
    $this->_data = $FILE['data'];
    $this->_extension = parent::get_extension();
  }

  public function write($user_id){
    // directory in which the uploaded file will be moved
    $user_dir = parent::get_user_dir_path($user_id);
    $dest_path = $user_dir ."/". $this->_name;
    if (!file_exists($user_dir)) {
      mkdir($user_dir, 0777, true);
    }
    if(file_put_contents($dest_path, file_get_contents($this->_data))) return true;
    else return false;
  }
}

class ConcreteFile extends AbstractFile implements \Mvc\Listable{

  private $realFiles = ["Text", "Pdf", "Compressed", "Audio", "Video", "Image"];

  public function __construct($NAME, $id){
    parent::__construct($NAME, $id);
    parent::set_user_id($id);
    $this->get_user_dir_path($id);
    $this->read_metadata_file();
  }

  public function get_name(){ return $this->_name;}

  public function get_icon_preview(){ return "insert_drive_file"; }
  public function get_color_preview(){  return "grey-text";  }
  public function build(){
    foreach($this->realFiles as $class){
      $ptr_class = "FileManager\\".$class."File";
      if(in_array($this->_extension, $ptr_class::get_allowed_types())){
        $file = new $ptr_class($this->_name, $this->_user_id);
        return $file;
      }
    }
    return $this;
  }

  private function read_metadata_file(){
    $path = $this->_path."/".$this->_name;
    $meta = stat($path);
    $this->_size = $meta['size'];
    $this->_data = $meta['mtime'];
    parent::get_extension();
  }

}

interface RealFile{
  public static function get_allowed_types();
}

final class TextFile extends ConcreteFile implements RealFile, \Mvc\Listable{

  public function __construct($NAME, $id){
    parent::__construct($NAME, $id);
  }

  public function get_icon_preview(){ return "article"; }
  public function get_color_preview(){  return "grey-text";  }

  public static function get_allowed_types(){
    return ["txt", "doc", "docx", "odt"];
  }

}
final class PdfFile extends ConcreteFile implements RealFile, \Mvc\Listable{

  public function __construct($NAME, $id){
    parent::__construct($NAME, $id);
  }

  public function get_icon_preview(){ return "picture_as_pdf";  }
  public function get_color_preview(){  return "orange-text";  }


  public static function get_allowed_types(){
    return ["pdf"];
  }

}
final class CompressedFile extends ConcreteFile implements RealFile, \Mvc\Listable{

  public function __construct($NAME, $id){
    parent::__construct($NAME, $id);
  }

  public function get_icon_preview(){ return "border_outer"; }
  public function get_color_preview(){  return "brown-text";  }

  public static function get_allowed_types(){
    return ["zip", "7z", "rar", "gz", "tar"];
  }

}

final class AudioFile extends ConcreteFile implements RealFile, \Mvc\Listable{

  public function __construct($NAME, $id){
    parent::__construct($NAME, $id);
  }

  public function get_icon_preview(){ return "audiotrack";  }
  public function get_color_preview(){  return "amber-text text-lighten-2";  }

  public static function get_allowed_types(){
    return ["mp3", "wma", "m4a", "flac", "wav", "webm"];
  }

}
final class VideoFile extends ConcreteFile implements RealFile, \Mvc\Listable{

  public function __construct($NAME, $id){
    parent::__construct($NAME, $id);
  }

  public function get_icon_preview(){ return "play_circle_filled";  }
  public function get_color_preview(){  return "light-blue-text";  }

  public static function get_allowed_types(){
    return ["ogg", "mp4", "mpeg", "avi", "wmv", "gifv", "amv", "mpg", "mpg2", "m4v"];
  }

}

final class ImageFile extends ConcreteFile implements RealFile, \Mvc\Listable, \Mvc\Printable{

  public function __construct($NAME, $id){
    parent::__construct($NAME, $id);
  }

  public function get_icon_preview(){ return "insert_photo";  }
  public function get_color_preview(){  return "red-text text-darken-1";  }

  public static function get_allowed_types(){
    return ["png", "jpg", "jpeg", "tiff", "exif", "gif", "bmp", "bpg", "svg"];
  }

  public function printPreview(){ ?><?php }
}
?>
