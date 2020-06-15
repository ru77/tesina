var containerdiv;
function ExplorerCommand(container){
  containerdiv = container;
}
ExplorerCommand.prototype = new CommandInterface("explorer");
ExplorerCommand.prototype.buildRequest = function(folder = ""){
  this.data = { folder : folder };
  this.execute(update, err);
}


function update(data){
  $(containerdiv).empty();
  $(containerdiv).html(data);
}

function err(data){}

function doNothing(){}
