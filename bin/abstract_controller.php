<?php namespace Mvc;

  abstract class AbstractController{

    private $_request;
    private $_data;

    protected function __construct($REQUEST, $DATA){
      $this->_request = $REQUEST;
      $this->_data = $DATA;
    }

    protected function getRequest(){ return $this->_request; }
    protected function getData(){ return $this->_data; }
  }

 ?>
