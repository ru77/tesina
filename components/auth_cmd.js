function AuthCommand(){}

AuthCommand.prototype = new CommandInterface("auth");
AuthCommand.prototype.buildRequest = function(success, error){
  var form = document.getElementById("user_authentication");
  var email = form.elements.email.value;
  var psw = form.elements.password.value;
  this.data = { email: email, psw: psw };
  this.execute(success, error);
}
