var obj = $("#dragandrophandler");
obj.on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', '2px solid #0B85A1');
});
obj.on('dragover', function (e) 
{
     e.stopPropagation();
     e.preventDefault();
});
obj.on('drop', function (e) 
{
 
     $(this).css('border', '2px dotted #0B85A1');
     e.preventDefault();
     var files = e.originalEvent.dataTransfer.files;
 
     //We need to send dropped files to Server
     handleFileUpload(files,obj);
});
$(document).on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});
$(document).on('dragover', function (e) 
{
  e.stopPropagation();
  e.preventDefault();
  obj.css('border', '2px dotted #0B85A1');
});
$(document).on('drop', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});
function handleFileUpload(files,obj)
{
    var acceptableFormats = ["webm" , "avi" , "mp4" , "mkv" , "mov" , "mpeg4" , "wmv" , "flv"];
    for (var i = 0; i < files.length; i++) 
    {
      var fileType = files[i].name.split(".");
      fileType = fileType[fileType.length - 1];
      fileType = fileType.toLowerCase();
      if (acceptableFormats.indexOf(fileType) == -1)
      {
        alert("You are only allowed to upload the following formats: mp4, mov, flv, webm, avi");
      }
      else
      {
        var fileName = files[i].name;
        var fileSize = files[i].size;
        var file = files[i];
        $.ajax({
        url: "http://plychannel.com/Include/makeUploadForm.php",
        type: 'post',
        data: { title:fileName },
        success: function(data){
          var fd = new FormData();
          fd.append('file', file);
          var status = new createStatusbar($("#AllUploads"), $(data));
          status.setFileNameSize(fileName,fileSize);
          status.videoID = status.uploadForm.attr("number");
          status.refeshSaveFunctions();
          sendFileToServer(fd,status);
          }
        });
      }
    }
}
function sendFileToServer(formData,status)
{
    var uploadURL ="http://plychannel.com/Include/videoConverter.php?u=" + status.videoID; //Upload URL
    var extraData ={}; //Extra Data.
    var jqXHR=$.ajax({
            xhr: function() {
            var xhrobj = $.ajaxSettings.xhr();
            if (xhrobj.upload) {
                    xhrobj.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        //Set progress
                        status.setProgress(percent);
                    }, false);
                }
            return xhrobj;
        },
        url: uploadURL,
        type: "POST",
        contentType:false,
        processData: false,
        cache: false,
        data: formData,
        success: function(data){
          status.setProgress(100);
          if (data != "ERROR")
          {
            status.pid = data;
            status.setAbort($(""), status.pid, status.videoID);
          }
          else
          {
            $(".filename").html("Sorry, But there was a error.");
          }
        }
    }); 
 
    status.setAbort(jqXHR, '-1', status.videoID);
}
function createStatusbar(obj, uploadData)
{

  this.statusbar = $("<div class='statusbar odd'></div>");
  //Original Title
  this.filename = $("<span class='filename'></span>").appendTo(this.statusbar);
  //File Size
  this.size = $("<span class='filesize'></span>").appendTo(this.statusbar);
  //Progress Bar
  this.progressBar = $("<br /><div style='width: 425px;position: relative;left: -30px;' class='progress progress-striped active'><div id='RealProgress' class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='60' aria-valuemin='0' aria-valuemax='100' style='width: 60%'><span class='sr-only'>60% Complete (warning)</span></div></div>").appendTo(this.statusbar);
  //Abort Button
  this.abort = $("<button type='button' class='btn btn-xs btn-danger abort'>Abort</button>").appendTo(this.statusbar);

  this.friendlyMessage = false;
  this.aborted = false;
  this.doneUpload = false;

  this.uploadForm = uploadData.appendTo(this.statusbar)
  obj.after(this.statusbar);

  this.refeshSaveFunctions = function()
  {
    $('[id=inputArea]').each(function(){
      $(this).unbind("change");
      $(this).change(function(){
          var inputData = $(this).val();
          var inputType = $(this).attr("infoType");
          var id = $(this).attr("number");

          if (inputType == "privacy")
          {
            if ($(this).val() == "p")
              $("#UsersAllowedInput").slideDown(300);
            else
              $("#UsersAllowedInput").slideUp(300);
          }

          $.ajax({
          url: "http://plychannel.com/Include/updateVideoInfo.php",
          type: 'post',
          data: { inputData:inputData, inputType:inputType, id:id },
          success: function(data){
              $("#messageNumber_" + id).html(data);
              $("#messageNumber_" + id).slideDown(300);
            }
          });
      });
    });

    $('[id=hidder]').each(function(){
      $(this).unbind("click");
      $(this).click(function(){
        if ($(this).html() == "Less")
        {
          $(this).html("More");
          $("#uploadForm_" + $(this).attr("number")).css("height", "25px");
        }
        else
        {
          $(this).html("Less");
          $("#uploadForm_" + $(this).attr("number")).css("height", "auto");
        }
      });
    });
  }

  this.setFileNameSize = function(name,size)
  {
    var sizeStr="";
    var sizeKB = size/1024;
    if(parseInt(sizeKB) > 1024)
    {
        var sizeMB = sizeKB/1024;
        sizeStr = sizeMB.toFixed(2)+" MB";
    }
    else
    {
        sizeStr = sizeKB.toFixed(2)+" KB";
    }

    this.filename.html(name);
    this.size.html(sizeStr);
  }
  this.setFileName = function(name)
  { 
    this.filename.html(name);
  }
  this.setProgress = function(progress)
  {
    if (!this.doneUpload)
      this.progressBar.children("#RealProgress").css('width', parseInt(progress) + '%');
    if(parseInt(progress) >= 100 && !this.doneUpload)
    {
      this.progressBar.children("#RealProgress").css('width', '0%');
      $("#messageNumber_" + this.videoID).html("Almost done, it is now getting processed.");
      $("#messageNumber_" + this.videoID).slideDown(300);
      this.friendlyMessage = true;
      $(this).unload(function(){
          $.ajax({
              type: 'POST',
              url: 'http://plychannel.com/Include/stopConverter.php',
              async:false,
              data: { pid:status.pid }
          });
          $.ajax({
            url: "http://plychannel.com/Include/abortUpload.php",
            type: 'post',
            async:false,
            data: { id:status.videoID }
          });
        });
      setInterval(ConvertVideo(this),2000);
      this.doneUpload = true;
    }
  }
  this.setAbort = function(jqxhr, convert, videoID)
  {
    var sb = this.statusbar;
    this.abort.unbind("click");
    this.abort.click(function()
    {
      if (convert != '-1')
      {
        StopConversion(convert);
        sb.hide();
        this.aborted = true;
      }
      else
      {
        jqxhr.abort();
        sb.hide();
        this.aborted = true;
      }
      $.ajax({
      url: "http://plychannel.com/Include/abortUpload.php",
      type: 'post',
      data: { id:videoID, name: this.filename.html()},
      success: function(data){
        console.log(data);
        }
      });
    });
  }
}

function ConvertVideo(status)
{
  if (!status.aborted && status.progressBar.children("#RealProgress").css('width') != "100%")
  {
    $.ajax({
    url: "http://plychannel.com/Include/getProgress.php",
    type: 'post',
    data: { id:status.videoID, name:status.filename.html() },
    success: function(data){
        status.progressBar.children("#RealProgress").css('width', data + '%');
        if (data >= 100)
        {
          status.progressBar.children("#RealProgress").css('width', "100%");
          $("#messageNumber_" + status.videoID).html("Video is now uploaded.");
          $("#messageNumber_" + status.videoID).slideDown(300);
          status.progressBar.remove();
          status.abort.remove();
        }
        setInterval(ConvertVideo(status), 1000);
      }
    });
  }
}

function StopConversion(pid)
{
  $.ajax({
  url: "http://plychannel.com/Include/stopConverter.php",
  type: 'post',
  data: { pid:pid },
  success: function(data){
    }
  });
}

$(window).bind('beforeunload', function(){
  return "Are you sure you want to leave, All of your videos that are uploading will be lost. If you leave it might take us a few second to despose of the data.";
});