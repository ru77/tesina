<?php
class File{
  private $_name;
  private $_size;
  private $_type;

  function __construct($name,$size,$type){
    $this->$_name = $name;
    $this->$_size = $size;
    $this->$_type = $type;
  }

}
?>
