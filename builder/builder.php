<?php namespace FrontEndBuilder;

class Builder{

  private $_page;

  public function __construct($type){
    if($type){
      $page_class = "FrontEndBuilder\\".$type;
      $this->_page = new $page_class();
    }
  }

  public function buildHeader(){
    header('Content-Type: text/html');  
  }

  public function build(){
    $this->_page->header(); ?>
    <body>
      <?php $this->_page->make(); ?>
    </body>
    <?php
    $this->_page->footer();
  }
}

?>
