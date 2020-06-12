<?php namespace UsersManager;


  final class FactoryUser{
    public final static function getUser($DB_OBJ){
      if(isset($DB_OBJ['type']) && $DB_OBJ['type'] == 1)
        return new Admin($DB_OBJ);
      else return new User($DB_OBJ);
    }

    public final static function insertUser($user){
      $user = FactoryUser::createUser($user);
      return new ServiceUser()->insert($user);
    }

    public final static function createUser($user_obj){
      $obj = array("email" => $user_obj['email'], "username" => explode('@', $user_obj['email'])[0], "id" => 0, "type" => 0);
      return FactoryUser::getUser($obj);
    }
  }

  class User{
    private $_username;
    private $_email;
    private $_user_id;
    private $_psw;
    private final $_super = false;

    public function __construct($DB_OBJ){
      $this->_username = (isset($DB_OBJ['username']) ? $DB_OBJ['username'] : null);
      $this->_email = (isset($DB_OBJ['email']) ? $DB_OBJ['email'] : null);
      $this->_user_id = $DB_OBJ['user_id'];
    }

    public function set_email($emailaddress){
      $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
      if (preg_match($pattern, $emailaddress) === 1) {
          $this->_email = $emailAddress;
      }
    }
    public function set_username($username){  $this->_username = $username; }
    public function set_id($id){  $this->_id = $id; }
    public function set_psw($psw){ $this->_psw = $psw; }

    public function get_username(){ return $this->_username; }
    public function get_id(){ return $this->_user_id; }
    public function get_email(){ return $this->_email; }
    public function get_psw(){ return  $this->_psw; }
    public function get_type(){ return ($this->_super ? 1 : 0);}
  }


  final class Admin extends User{
    private final $_super = true;

    public function __construct($DB_OBJ){
      parent::__construct($DB_OBJ);
    }
  }

  class ServiceUser extends Mvc\AbstratService{
    private $_user = null;

    public function __construct(){ parent::__construct(); }

    public function get($user_id){
      $query = "SELECT * FROM Users WHERE id = ?";
      $stmt = parent::$_db->prepare($query);
      $stmt->bindParam($user_id);
      if($stmt->execute()){
        $this->_user = FactoryUser::getUser($stmt->fetch());
      }
      return $this->_user;
    }

    public function delete($user_id){}

    public function insert($user){
      $cmd = 'INSERT INTO Users(username,email,password,type) VALUES(:username,:email,:password,:type)';
      $stmt = parent::$_db->prepare($cmd);
      $stmt->bindValue(':username', $user->get_username());
      $stmt->bindValue(':email', $user->get_email());
      $stmt->bindValue(':password', $user->get_psw());
      $stmt->bindValue(':type', $user->get_type());
      if($stmt->execute()){
        $id = parent::$_db->lastInsertId();
        $user->set_id($id);
        return $user;
      }else return false;
    }

    public function list($filters){}
  }
?>
