function RegisterCommand(){}

RegisterCommand.prototype = new CommandInterface("register");
RegisterCommand.prototype.buildRequest = function(){
  var form = document.getElementById("user_registration");
  var email = form.elements.email.value;
  var psw = form.elements.password.value;
  this.data = { email: email, psw: psw };
  this.execute(done, error);
}
function done(data){
  M.toast({html: "Authenticated correctly"});
  window.location.href = "dashboard";
}

function error(data){
  M.toast({html: "Oh oh! incorrect email or password!"});
}
