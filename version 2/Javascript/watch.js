var isMouseOver = false;

$("[id=pageTab]").each(function(){
	$(this).click(function(){
		$("#pageTabs").children("#pageTab").attr("class", "pageTab");
		$(this).attr("class", "pageActiveTab");
		$("#pages").children().slideUp(500);
		var number = $(this).attr("number");
		$("#page_" + number).slideDown(500);
	});
});

$("#showHideDescription").click(function(){
	if ($(this).attr("class") == "showMore")
	{
		$(".smallDes").css("display", "none");
		$(".bigDes").css("display", "block");
		$(this).attr("class", "showLess");
	}
	else
	{
		$(".smallDes").css("display", "block");
		$(".bigDes").css("display", "none");
		$(this).attr("class", "showMore");
	}
});

function newPopup(w, h, url) {
	popupWindow = window.open(url,'popUpWindow','height='+h+',width='+w+',left=10,top=10,resizable=false,scrollbars=false,toolbar=false,menubar=no,location=no,directories=no,status=false');
}

$("#flagMessage").keyup(function(){
	var count = $("#flagMessage").val().length;
	$("#flagCharactersRemaining").html((500 - count) + " Characters Remaining");
});

//Comments

function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight + 200) + 'px';
}

$("#commentLeaverButton").mouseenter(function(){
	isMouseOver = true;
});

$("#commentLeaverButton").mouseout(function(){
	isMouseOver = false;
});

$("#commentLeaverButton").click(function(){
	var comment = $("#commentLeaver").val();
	var vid = $("#id").val();
	$.ajax({
		url: "PHP/leaveComment.php",
		type: 'post',
		data: { comment: comment, vid: vid, parent: '0' },
		success: function(data){
			var value = $("#commentsOrder").val();
			$("#commentsWindow").attr("src", "PHP/comments?o="+value+"&v=" + $("#encid").val());
			if (value == "latest")
				$(liveComments).parent().css("display", "inline-block");
			else
				$(liveComments).parent().css("display", "none");

			$("#commentLeaver").val("");
		}
	});
});

$("#commentLeaver").focus(function(){
	$("#commentLeaverButton").css("display", "block");
});

$("#commentLeaver").blur(function(){
	if (!isMouseOver)
		$("#commentLeaverButton").css("display", "none");
});

setInterval(function(){
	if($("#liveComments").is(":checked") && $("#commentsOrder").val() == "latest")
		$("#commentsWindow").attr("src", "PHP/comments?o=latest&v=" + $("#encid").val());
}, 5000);

$("#commentsOrder").change(function(){
	var value = $(this).val();
	$("#commentsWindow").attr("src", "PHP/comments?o="+value+"&v=" + $("#encid").val());
	if (value == "latest")
		$(liveComments).parent().css("display", "inline-block");
	else
		$(liveComments).parent().css("display", "none");
});


//Playlist Manager

rebindClickToPlaylistItems();
function rebindClickToPlaylistItems()
{
	$("[id=playlistItem]").each(function(){
		$(this).unbind("click");
		$(this).click(function(){
			var inPlaylist = $(this).attr("inPlaylist");
			var plID = $(this).attr("plID");
			var id = $("#id").val();

			$.ajax({
				url: "PHP/addTo.php",
				type: 'post',
				data: { playlist: plID, videoID: id },
				success: function(data){
					if ($("#playlistTickMark_" + plID).css("display") == "none")
						$("#playlistTickMark_" + plID).css("display", "inline-block");			
					else
						$("#playlistTickMark_" + plID).css("display", "none");
				}
			});
		});
	});
}

$("#playlistCreator").click(function(){
	var name = $("#playlistName").val();
	var privacy = $("#playlistPrivacy").val();
	var id = $("#id").val();

	$.ajax({
		url: "PHP/addTo.php",
		type: 'post',
		data: { playlist: privacy, videoID: id, plName: name },
		success: function(data){
			$("#playlistContainer").append(data);
			rebindClickToPlaylistItems();
		}
	});
});

//Like Buttons for video

$("#likeButton").click(function(){
	$.ajax({
		url: "PHP/liked.php",
		type: 'post',
		data: { like: '1', id: $("#id").val() },
		success: function(data){
			if ($("#likeButton").attr("class") != "liked")
			{
				$("#likeButton").attr("class", "liked");
				$("#dislikeButton").attr("class", "dislike");
			}
			else
			{
				$("#likeButton").attr("class", "like");
				$("#dislikeButton").attr("class", "dislike");
			}
		}
	});
});

$("#dislikeButton").click(function(){
	$.ajax({
		url: "PHP/liked.php",
		type: 'post',
		data: { like: '0', id: $("#id").val() },
		success: function(data){
			if ($("#dislikeButton").attr("class") != "disliked")
			{
				$("#likeButton").attr("class", "like");
				$("#dislikeButton").attr("class", "disliked");
			}
			else
			{
				$("#likeButton").attr("class", "like");
				$("#dislikeButton").attr("class", "dislike");
			}
		}
	});
});