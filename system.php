<?php
final class System{
  private static $_config;

  public static function init(){
    System::$_config = json_decode(file_get_contents(".manifest"), true);
  }

  private static function require_file($name){require_once($name);}

  public static function get_abs(){return System::$_config["ABS_PATH"];}
  public static function get_file_lib(){System::require_file(System::$_config["LIBS"]["FilesManager"]);}
  public static function get_user_lib(){System::require_file(System::$_config["LIBS"]["UserManager"]);}
  public static function get_database_lib(){System::require_file(System::$_config["LIBS"]["DatabaseManager"]);}
  public static function get_builder_lib(){System::require_file(System::$_config["LIBS"]["FrontEndBuilder"]["BUILDER"]);}
  public static function get_pages_lib(){System::require_file(System::$_config["LIBS"]["FrontEndBuilder"]["PAGES"]);}
  public static function get_auth_lib(){System::require_file(System::$_config["LIBS"]["AuthManager"]["AUTH"]);}
  public static function get_session_lib(){System::require_file(System::$_config["LIBS"]["AuthManager"]["SESSION"]);}
  public static function get_file_controller(){System::require_file(System::$_config["CONTROLLERS"]["FILE"]);}
  public static function get_controller(){System::require_file(System::$_config["MVC"]["CONTROLLER"]);}
  public static function get_service(){System::require_file(System::$_config["MVC"]["SERVICE"]);}
  public static function get_model(){System::require_file(System::$_config["MVC"]["MODEL"]);}
  public static function get_user_files(){System::require_file(System::$_config["USER_FILE_LOCATION"]);}
  public static function get_command_interface(){System::require_file(System::$_config["LIBS"]["Commands"]["INTERFACE"]);}
  public static function get_auth_command(){System::require_file(System::$_config["LIBS"]["Commands"]["AUTH"]);}
  public static function get_register_command(){System::require_file(System::$_config["LIBS"]["Commands"]["REGISTER"]);}
  public static function get_upload_command(){System::require_file(System::$_config["LIBS"]["Commands"]["UPLOAD"]);}
  public static function get_explorer_command(){System::require_file(System::$_config["LIBS"]["Commands"]["EXPLORER"]);}


}
?>
