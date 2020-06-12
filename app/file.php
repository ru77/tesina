<?php namespace FileManager;

final class FactoryFile{
  public static final function uploadFile($file, $user_id){
    $file = new UploadedFile($file);
    return $file->write($user_id);
  }
}

abstract class AbstractFile{
  protected $_name;
  protected $_date;
  protected $_extension;
  protected $_size;
  protected $_path;
  protected $_user_id;

  protected function __construct($PATH){
    $this->_path = $PATH;
    // estrapolare il nome;
    // $this->_name = $NAME;
    // $this->_extension = $EXT;
    // delegare a read_metadata_file per la lettura dei metadati del file
     $this->read_metadata_file();
  }

  private function read_metadata_file(){
    $meta = stat($this->_path."/".$this->_name);
    // $this->_size = $meta['size'];
    // $this->_data = ..
  }

  protected function get_user_dir_path($_user_id, $_prefix = "../"){
    return $_prefix."_files/".$_user_id;
  }

}

final class UploadedFile extends AbstractFile{
  private $_tmp_path;

  protected function __construct($FILE){
    $this->_tmp_path = $FILE['uploadedFile']['tmp_name'];
    $this->_name = $FILE['uploadedFile']['name'];
    $this->_size = $FILE['uploadedFile']['size'];
    //$fileType = $FILE['uploadedFile']['type'];
    $fileNameCmps = explode(".", $this->_name);
    $this->_extension = strtolower(end($fileNameCmps));
  }

  protected function write($user_id){
    // directory in which the uploaded file will be moved
    $user_dir = parent::get_user_dir_path($user_id);
    $dest_path = $user_dir ."/". $this->_name;
    if(move_uploaded_file($this->_tmp_path, $dest_path)) return true;
    else return false;
  }
}

class ConcreteFile extends AbstractFile{}

final class TextFile extends AbstractFile{}
final class PdfFile extends AbstractFile{}
final class CompressedFile extends AbstractFile{}

abstract class MediaFile extends AbstractFile{}

final class AudioFile extends MediaFile{}
final class VideoFile extends MediaFile{}
final class ImageFile extends MediaFile{}
?>
