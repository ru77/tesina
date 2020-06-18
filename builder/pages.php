<?php namespace FrontEndBuilder;

abstract class AbstractPage{
  private $_titlePage;
  private $_prefix;

  protected function __construct($titlePage, $prefix = "./"){
    $this->_prefix = $prefix;
    $this->_titlePage = $titlePage;
  }

  public function makeNav($footer = false){
    if(!$footer){ ?>
      <nav>
        <div class="nav-wrapper black-text light-blue" >
          <a href="#" class="brand-logo" style="margin-left:10px;"><i class="large material-icons">cloud</i>&nbsp;SimpleCloud</a>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
    <?php }else{ ?>
          <ul>
    <?php } ?>
          <li><a class="grey-text text-lighten-3" href="<?=$this->_prefix;?>">Dashboard</a></li>
    <?php if(!$GLOBALS['session_handler']->check_user_session()){?>
            <li><a class="grey-text text-lighten-3" href="<?=$this->_prefix;?>login">Login</a></li>
            <li><a class="grey-text text-lighten-3" href="<?=$this->_prefix;?>signup">Sign Up</a></li>
    <?php }else{ ?>
            <li class="white-text">Hi <?= ucfirst($GLOBALS['session_handler']->get_name()); ?></li>
            <li><a class="grey-text text-lighten-3" href="<?=$this->_prefix;?>request/deauth">Disconnect</a></li>
    <?php } ?>
        </ul>
    <?php if(!$footer){ ?>
      </div>
    </nav>
    <?php }
  }

  abstract function style();
  abstract function scripts();
  abstract function make();

  public function header(){
    ?>
    <!DOCTYPE>
    <head>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title><?=$this->_titlePage;?> |Simple Cloud</title>
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
    <script src="js/command"></script>
    <?php $this->scripts(); ?>
    <footer class="page-footer indigo">
        <div class="container">
          <div class="row">
            <div class="col l6 s12">
              <h5 class="white-text">Local Cloud System</h5>
            </div>
            <div class="col l4 offset-l2 s12">
              <h5 class="white-text">Links</h5>
              <?php $this->makeNav(true);?>
            </div>
          </div>
        </div>
        <div class="footer-copyright">
          <div class="container">
          Tesina Esame di Stato
          </div>
        </div>
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
      <div class="col l2 m2 s12">
        <h3>Directory</h3>
        <ul class="collection" id="folders">
          <li class="collection-item active valign-wrapper">
            <i class="material-icons" class="left">home</i>
             &nbsp;&nbsp;&nbsp;
            <span class="title right">Home</span>
          </li>
          <li class="collection-item valign-wrapper light-blue white-text">
            <i class="material-icons" class="left">create_new_folder</i>
             &nbsp;&nbsp;&nbsp;
            <span class="title right">Create Folder</span>
          </li>
        </ul>
      </div>
      <div class="col l10 m10 s12 files">
        <h3>Explorer</h3>
          <div class="explorer">
            <div class="lister" id="files">
            </div>
          </div>
      </div>
    </div>


    <?php if($GLOBALS['session_handler']->check_user_session()){?>
    <div class="fixed-action-btn">
      <div>
        <!--form enctype="multipart/form-data" id="form-upload"-->
          <button class="btn-floating btn-large red">
            <label class="custom-file-upload">
                <input type="file" name="file" id="file_upload"/>
                <i class="large material-icons">cloud_upload</i>
            </label>
          </button>
        <!--/form-->
      </div>
    </div>
    <?php }
  }

  function style(){
    ?>
    .files{
      width:100%;
      height: 100%;
    }
    input[type="file"] {
      display: none;
    }
    .custom-file-upload {
      cursor: pointer;
    }
    .explorer{
      height: 100% !important;
      max-height:100%;
      overflow-y: auto;
      overflow-x: hidden;
      padding: 10px;
    }
    .lister{
      height:auto;
    }
    <?php
  }
  function scripts(){
    ?>
    <script src="js/upload"></script>
    <script src="js/explorer"></script>
    <script src="js/auth"></script>
    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
      var authenticator = new AuthCommand();
      authenticator.autoSign();
      var explorer = new ExplorerCommand("#files");
      explorer.buildRequest();
      var elems = document.querySelectorAll('.fixed-action-btn');
      var instances = M.FloatingActionButton.init(elems);
      $(document).ready(function(){
        var up = new UploadCommand();
        $("#file_upload").on("change", function(e){
          up.buildRequest();
        })
     });

    });
    </script>
    <?php
  }

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
    var authenticator = new AuthCommand();
    var button = document.getElementById("auth_user");
    button.onclick = function(event){
      event.preventDefault();
      authenticator.buildRequest();
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
    var button = document.getElementById("reg_user");
    var registrator = new RegisterCommand();
    button.onclick = function(event){
      event.preventDefault();
      registrator.buildRequest();
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
