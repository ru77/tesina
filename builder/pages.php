<?php namespace FrontEndBuilder;

abstract class AbstractPage{
  private $_titlePage;
  private $_prefix;

  protected function __construct($titlePage, $prefix = "./"){
    $this->_prefix = $prefix;
    $this->_titlePage = $titlePage;
  }

  abstract function style();
  abstract function scripts();
  abstract function make();

  public function header(){
    ?>
    <head>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
      <title><?=$this->_titlePage;?> | Cloud</title>
      <style media="screen">
      <?php $this->style(); ?>
      </style>
    </head>
    <?php
  }

  public function footer(){
    ?>
    <script
			  src="http://code.jquery.com/jquery-3.5.1.min.js"
			  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <?php $this->scripts(); ?>
    <footer>

    </footer>
    <?php
  }

}

final class HomePage extends AbstractPage{
  function __construct(){
    parent::__construct("Home");
  }

  function make(){
    ?>
    <div class="row">
      <h1>Hello World!</h1>
    </div>
    <?php
  }
  function style(){}
  function scripts(){}

}

final class ViewPage extends AbstractPage{
  function __construct($id_file){
    parent::__construct("File ".$id_file);
  }

  function make(){
    ?>
    <div class="row">
      <h1>File View</h1>
    </div>
    <?php
  }
  function style(){}
  function scripts(){}
}

final class LoginPage extends AbstractPage{
  function __construct(){
    parent::__construct("Login");
  }

  function make(){
    ?>
    <div class="row bg blue darken-3" >
      <div class="col l4 m2 s1 x1"></div>
      <div class="col l4 m8 s10 x10 login-container">
        <div class="card white form">
          <div class="card-content black-text">
          <span class="card-title center">Log in</span>
          <form id="user_authentication">
            <div class="row">
              <div class="col m12 input-field">
                <input type="email" id="email">
                <label for="email">Email</label>
              </div>
              <div class="col m12 input-field">
                <input type="password" id="password">
                <label for="password">Password</label>
              </div>
              <div class="col m12 center">
                <button id="auth_user" class="btn-flat amber grey-text text-darken-4">Log in</button>
              </div>
            </div>
          </form>
        </div>
        </div>
      </div>
      <div class="col l4 m2 s1 x1"></div>
    </div>
    <?php
  }
  function style(){
    ?>
    .bg{
      height: 100vh;
      width: 100vw;
      margin-bottom: 0;
      overflow: hidden;
    }
    .login-container{
      padding-top: 70px !important;
    }
    .form{
      margin: 0 auto;
    }
     <?php
   }
  function scripts(){ ?>
    <script src="js/auth"></script>
    <script type="text/javascript">
    function done(data){
      M.toast({html: "Authenticated correctly"});
    }

    function error(data){
      M.toast({html: "Oh oh! incorrect email or password!"});
    }
    var button = document.getElementById("auth_user");
    var authenticator = new AuthCommand();
    button.onclick = function(event){
      event.preventDefault();
      authenticator.buildRequest(done, error);
    }
    </script>
    <?php
  }
}

final class SignUpPage extends AbstractPage{
  function __construct(){
    parent::__construct("Sign Up");
  }

  function make(){
    ?>
    <div class="row bg blue darken-3" >
      <div class="col l4 m2 s1 x1"></div>
      <div class="col l4 m8 s10 x10 login-container">
        <div class="card white form">
          <div class="card-content black-text">
          <span class="card-title center">Sign up</span>
          <form id="user_registration">
            <div class="row">
              <div class="col m12 input-field">
                <input type="email" id="email">
                <label for="email">Email</label>
              </div>
              <div class="col m12 input-field">
                <input type="password" id="password">
                <label for="password">Password</label>
              </div>
              <div class="col m12 center">
                <button id="reg_user" class="btn-flat amber grey-text text-darken-4">Sign up</button>
              </div>
            </div>
          </form>
        </div>
        </div>
      </div>
      <div class="col l4 m2 s1 x1"></div>
    </div>
    <?php
  }
  function style(){
    ?>
    .bg{
      height: 100vh;
      width: 100vw;
      margin-bottom: 0;
      overflow: hidden;
    }
    .login-container{
      padding-top: 70px !important;
    }
    .form{
      margin: 0 auto;
    }
    <?php
  }
  function scripts(){
    ?>
    <script src="js/register"></script>
    <script type="text/javascript">
    function done(data){
      M.toast({html: "Registrated correctly"});
    }

    function error(data){
      M.toast({html: "Error"});
    }
    var button = document.getElementById("reg_user");
    var registrator = new RegisterCommand();
    button.onclick = function(event){
      event.preventDefault();
      registrator.buildRequest(done, error);
    }
    </script>
    <?php
  }
}

final class ErrorPage extends AbstractPage{
  function __construct(){
    parent::__construct("Error");
  }

  function make(){
    ?>
    <div class="row">
      <h1>Hello Error!</h1>
    </div>
    <?php
  }
  function style(){}
  function scripts(){}
}
?>
