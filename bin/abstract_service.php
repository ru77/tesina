<?php namespace Mvc;

  abstract class AbstractService{
    protected static $_db = null;

    function __construct(){
      $this->initConnection();
    }

    protected function checkConnection(){ return ( self::$_db ? true : false);  }

    protected function initConnection(){
      self::$_db = \DatabaseManager::getInstance();
    }

    protected function closeConnection(){ self::$_db = null;  }

    abstract function get($ID);
    abstract function delete($ID);
    abstract function insert($OBJ);
    abstract function list($FILTERS);
  }

  ?>
