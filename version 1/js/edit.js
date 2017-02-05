$('[id=inputArea]').each(function(){
	$(this).change(function(){
		var id = $(this).attr('number');
		var type = $(this).attr('infoType');
		var data = $(this).val();
		if (type == "title")
		{
			$("#messageNumber_" + id).html($(this).val());
		}
		else if (type == "privacy")
		{
			if (data == "p")
              $("#UsersAllowedInput_" + id).slideDown(300);
            else
              $("#UsersAllowedInput_" + id).slideUp(300);
		}

		$.ajax({
			url: "http://plychannel.com/Include/updateVideoInfo.php",
			type: 'post',
			data: { inputData:data, inputType:type, id:id },
			success: function(data){
			}
		});
	});
});

$('[id=hidder]').each(function(){
	$(this).click(function(){
		var id = $(this).attr("number");
		if ($("#uploadForm_" + id).css("height") != "45px")
		{
			$(this).html("More");
			$("#uploadForm_" + id).css("height", "45px");
		}
		else
		{
			$(this).html("Less");
			$("#uploadForm_" + id).css("height", "auto");
		}
	});
});

$("[id=imageRefresher]").each(function(){
	$(this).click(function(){
		var refresher = $(this);
		refresher.css("display", "none");
		var id = $(this).attr("number");
		$.ajax({
			url: "http://plychannel.com/Include/refreshVideoImage.php",
			type: 'post',
			data: { id:id },
			success: function(data){
				$("#imageToRefresh_" + id).attr("src", $("#imageToRefresh_" + id).attr("src"));
				refresher.css("display", "block");
				$(".videoTime_" + id).html(data);
			}
		});
	});
})