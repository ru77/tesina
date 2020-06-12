function CommandInterface(target, prefix = '') {
  this.prefix = prefix;
  this.url = "request/";
  this.data;
  this.target = target;
}
CommandInterface.prototype.target;
CommandInterface.prototype.prefix;
CommandInterface.prototype.data;
CommandInterface.prototype.buildRequest = function(){}

CommandInterface.prototype.execute = function(callback_success, callback_error) {
  console.log("ex");
  jQuery.ajax({
    type: "POST",
    url: this.url,
    data: { target: this.target, payload: this.data },
    success: function(data){ callback_success(data); },
    error: function(error){ callback_error(error, false); },
  });
}
