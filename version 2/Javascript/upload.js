var uploadersID = 0;

$("#uploadDroper").mouseenter(function(){
	$("#uploadDroperImage").css("background", "url('Images/upload_hover.png') 100%");
});
$("#uploadDroper").mouseleave(function(){
	$("#uploadDroperImage").css("background", "url('Images/upload.png') 100%");
});
$("#uploadDroperImage").click(function(){
  CreateNewUpload();
});
$("#uploadDroper").on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', '2px solid #0B85A1');
});
$("#uploadDroper").on('dragleave', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', '0px solid #0B85A1');
});
$("#uploadDroper").on('dragover', function (e) 
{
     e.stopPropagation();
     e.preventDefault();
});
$("#uploadDroper").on('drop', function (e) 
{
	e.preventDefault();
	e.stopPropagation();
	e.preventDefault();
	var files = e.originalEvent.dataTransfer.files;
	$("#uploadingPage").css("display", "none");
	$("#uploadingVideos").css("display", "block");
	prepareToUpload(files);
});

$("#addMore").click(function(){
  CreateNewUpload();
});

function CreateNewUpload()
{
  $("#fileUploaders").prepend("<input type='file' id='uploadFile"+uploadersID+"' style='display: none;' multiple />");
  $("#uploadFile"+uploadersID).change(function(){
    $("#uploadingPage").css("display", "none");
    $("#uploadingVideos").css("display", "block");
    prepareToUpload(this.files);
  });
  $("#uploadFile"+uploadersID).trigger("click");
  uploadersID++;
}

//Uploader

function prepareToUpload(files)
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
          url: "PHP/makeUploadForm.php",
          type: 'post',
          data: { title:fileName },
          success: function(data){
            $("#uploadingVideos").prepend(data);
            var fd = new FormData();
            fd.append('file', file);
            var id = $("#ptitle", data).attr("number");
            rebindSaves();
            uploadFile(fd, id, fileName);
          }
        });
      }
    }
}

function uploadFile(formData, id, fileName)
{
  var uploadURL = "PHP/videoConverter.php?id=" + id;
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
            $("[id=progressBar]").each(function(){
              if ($(this).attr("number") == id)
              {
                if (percent != 100)
                {
                  $(this).css("width", percent + "%");
                }
                else
                {
                  $(this).css("background", "#fff");
                  $(this).html("Video Uploaded");
                }
              }
            });
          }
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
    success: function(pid){
      createVideoImage(id, fileName);
      setInterval(function(){
        $.ajax({
          url: "PHP/getProgress.php",
          type: 'post',
          data: { id: id },
          success: function(data){
            $("[id=progressBar]").each(function(){
              if ($(this).attr("number") == id)
              {
                if (data != "done")
                {
                  $(this).css("width", data + "%");
                }
                else
                {
                  $(this).remove();
                  $("[id=cancelButton]").each(function(){
                    if ($(this).attr("number") == id)
                    {
                      $(this).remove();
                    }
                  });
                }
              }
            });

            $("[id=cancelButton]").each(function(){
              if ($(this).attr("number") == id)
              {
                $(this).unbind("click");
                $(this).click(function(){
                  jqXHR.abort();
                  $.ajax({
                  url: "PHP/abortUpload.php",
                  type: 'post',
                  data: { id:id, pid: pid },
                  success: function(data){
                    console.log(data);
                    $("[id=videoUpload]").each(function(){
                      if ($(this).attr("number") == id)
                      {
                        $(this).remove();
                      }
                    });
                    }
                  });
                });
              }
            });
          }
        });
      },2000);
    }
  });

  $("[id=cancelButton]").each(function(){
    if ($(this).attr("number") == id)
    {
      $(this).click(function(){
        jqXHR.abort();
        $.ajax({
        url: "PHP/abortUpload.php",
        type: 'post',
        data: { id:id },
        success: function(data){
          console.log(data);
          $("[id=videoUpload]").each(function(){
            if ($(this).attr("number") == id)
            {
              $(this).remove();
            }
          });
          }
        });
      });
    }
  });
}

function createVideoImage(id, fileName)
{
  $.ajax({
    url: "PHP/createVideoImage.php",
    type: 'post',
    data: { id:id, name: fileName },
    success: function(data){
      $("[id=background]").each(function(){
        if ($(this).attr("number") == id)
        {
          $(this).css("background", "url('http://plychannel.com/Uploads/"+id+".jpg')");
          $(this).css("background-size", "100% 100%");
        }
      });
    }
  });
}

function rebindSaves()
{
  $("[id=title]").each(function(){
    $(this).unbind("change");
    $(this).change(function(){
      var id = $(this).attr("number");
      var data = $(this).val();
      var type = "title";
      saveVideoInfo(id, type, data);
    });
  });

  $("[id=description]").each(function(){
    $(this).unbind("change");
    $(this).change(function(){
      var id = $(this).attr("number");
      var data = $(this).val();
      var type = "description";
      saveVideoInfo(id, type, data);
    });
  });

  $("[id=tags]").each(function(){
    $(this).unbind("change");
    $(this).change(function(){
      var id = $(this).attr("number");
      var data = $(this).val();
      var type = "tags";
      saveVideoInfo(id, type, data);
    });
  });

  $("[id=category]").each(function(){
    $(this).unbind("change");
    $(this).change(function(){
      var id = $(this).attr("number");
      var data = $(this).val();
      var type = "category";
      saveVideoInfo(id, type, data);
    });
  });

  $("[id=privacy]").each(function(){
    $(this).unbind("change");
    $(this).change(function(){
      var id = $(this).attr("number");
      var data = $(this).val();
      var type = "privacy";
      saveVideoInfo(id, type, data);
    });
  });

  $("[id=allowComments]").each(function(){
    $(this).unbind("change");
    $(this).change(function(){
      var id = $(this).attr("number");
      var data = $(this).is(':checked');
      var type = "comments";
      saveVideoInfo(id, type, data);
    });
  });
}

function saveVideoInfo(id, type, data)
{
  $.ajax({
    url: "PHP/updateVideoDetails.php",
    type: 'post',
    data: { id:id, type: type, data: data },
    success: function(data){
    }
  });
}

$(window).bind('beforeunload', function(){
  return "Are you sure you want to leave, All of your videos that are uploading will be lost. If you leave it might take us a few second to despose of the data.";
});