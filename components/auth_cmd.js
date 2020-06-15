function AuthCommand(){}
AuthCommand.prototype = new CommandInterface("auth");
AuthCommand.prototype.buildRequest = function(){
  var form = document.getElementById("user_authentication");
  var email = form.elements.email.value;
  var psw = form.elements.password.value;
  this.data = { email: email, psw: psw };
  this.execute(done, error);
}

AuthCommand.prototype.autoSign = function(){
  this.data = { check: true };
  this.execute(doNothing, redirect);
}

function redirect(){
  window.location.href = "login";
}

function done(data){
  M.toast({html: "Authenticated correctly"});
  window.location.href = "dashboard";
}

function error(data){
  M.toast({html: "Oh oh! incorrect email or password!"});
}

function doNothing(){}
