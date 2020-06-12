<?php namespace Mvc;
  abstract class AbstractService{
    protected $_db = null;

    function __construct(){
      $this->initConnection();
    }

    protected function checkConnection(){ return ( $this->_db ? true : false);  }

    protected function initConnection(){  $this->_db = DatabaseManager::getInstance();  }

    protected function closeConnection(){ $this->_db = null;  }

    abstract function get($ID);
    abstract function delete($ID);
    abstract function insert($OBJ);
    abstract function list($FILTERS);
  }
  ?>
