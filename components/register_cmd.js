function RegisterCommand(){}

RegisterCommand.prototype = new CommandInterface("register");
RegisterCommand.prototype.buildRequest = function(success, error){
  var form = document.getElementById("user_registration");
  var email = form.elements.email.value;
  var psw = form.elements.password.value;
  this.data = { email: email, psw: psw };
  this.execute(success, error);
}
