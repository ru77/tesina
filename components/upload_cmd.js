function UploadCommand(){}
var _hidden;
UploadCommand.prototype = new CommandInterface("upload");

UploadCommand.prototype.buildRequest = function(){
  var input = document.getElementById("file_upload");
  var fileTypes = ["txt", "doc", "docx", "odt", "pdf", "zip", "7z", "rar", "gz", "tar", "mp3", "wma", "m4a", "flac", "wav", "webm", "ogg", "mp4", "mpeg", "avi", "wmv", "gifv", "amv", "mpg", "mpg2", "m4v", "png", "jpg", "jpeg", "tiff", "exif", "gif", "bmp", "bpg", "svg"];  //acceptable file types
  _hidden = this;
  if (input.files && input.files[0]) {
    var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
    isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types
    if (isSuccess) { //yes
      var reader = new FileReader();
      reader.onload = function (e) {
        var formData = e.target.result;
        var fileName = document.getElementById('file_upload').files[0].name;
        _hidden.data = { filename: fileName, data: formData };
        _hidden.execute(done_up, error_up);
      }
      reader.readAsDataURL(input.files[0]);
    }else { //no
      M.toast({html: "Oh oh! type not allowed!"});
    }
  }
}
function done_up(data){
  M.toast({html: "File uploaded!"});
}

function error_up(data){
  M.toast({html: "Oh oh! an error occour!"});
}
