<?php namespace FrontEndBuilder;

class Builder{

  private $_page;

  public function __construct($type){
    if($type){
      $page_class = "FrontEndBuilder\\".$type[0];
      $this->_page = new $page_class();
    }
  }

  public function buildHeader($type){
    switch($type){
      case "js":
        header('Content-Type: text/html; charset=UTF-8');
        header('Content-Type: multipart/form-data; boundary=something');
        break;
      default:
        header('Content-Type: text/html');
        break;
    }
  }

  public function build(){
    $this->_page->header(); ?>
    <body>
      <?php
      $this->_page->makeNav();
      $this->_page->make();
      ?>
    </body>
    <?php
    $this->_page->footer();
  }
}

?>
