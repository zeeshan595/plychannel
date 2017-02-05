$(window).resize(function() {
	resizeChannelVideo();
});
$(document).ready(function (){
	resizeChannelVideo();

	changeCommentSelection();

	$("#MoreShower").click(function() {
		if ($('#fullDiscription').css("display") == "none")
		{
			$("#fullDiscription").delay(300).slideDown(700);
			$("#smallDiscription").slideUp(300);
			$("#MoreShower").attr('class' , 'LessShower');
		}
		else
		{
			$("#fullDiscription").slideUp(300);
			$("#smallDiscription").delay(300).slideDown(700);
			$("#MoreShower").attr('class' , 'MoreShower');
		}
	});

	$("#commentSelection").change(function(){
		changeCommentSelection();
	});

	function changeCommentSelection()
	{
		var id = $("#id").val();
		var order;
		if ($("#commentSelection").val() == "top")
			order = 't';
		else
			order = 'l';

		$.ajax({
			url: "http://plychannel.com/Include/getComments.php",
			type: 'post',
			data: { id:id, order:order },
			success: function(data){
				$(".commentArea").html(data);

				RedrawPostButtons();
				RedrawnCommentPosts();
			}
		});
	}

	function RedrawPostButtons()
	{
		$('[id=ReplyComment]').each(function(){
			$(this).click(function(){
				$("#replier").remove();
				if ($(this).attr("parent") == "")
					$(this).parent().append( "<div class='media' id='replier' style='display:none;'><p id='commentPostTemp' style='display:none;color:#999999; font-size:15px; font-weight:bold;'></p><img width='50px' height='50px' class='media-object pull-left' src='http://plychannel.com/Images/author?u="+$("#user").val()+"'><div class='media-body'><textarea id='commentMessage' style='resize:none;height:75px;width:95%;'>#"+$(this).attr('author')+" </textarea><br /><table width='95%'><tr><td><span id='commentCharactersRemaining'>500 Characters Remaining</span></td><td align='right'><button id='postCommentMessage' reply='"+$(this).attr('number')+"' type='button' class='btn btn-s btn-primary'>Post</button></td></tr></table></div></div>" );
				else
					$(this).parent().parent().append( "<div class='media' id='replier' style='display:none;'><p id='commentPostTemp' style='display:none;color:#999999; font-size:15px; font-weight:bold;'></p><img width='50px' height='50px' class='media-object pull-left' src='http://plychannel.com/Images/author?u="+$("#user").val()+"'><div class='media-body'><textarea id='commentMessage' style='resize:none;height:75px;width:95%;'>#"+$(this).attr('author')+" </textarea><br /><table width='95%'><tr><td><span id='commentCharactersRemaining'>500 Characters Remaining</span></td><td align='right'><button id='postCommentMessage' reply='"+$(this).attr('parent')+"' type='button' class='btn btn-s btn-primary'>Post</button></td></tr></table></div></div>" );
				$("#replier").slideDown(700);
				RedrawnCommentPosts();
			});
		});
	}

	function RedrawnCommentPosts()
	{
		$('[id=postCommentMessage]').each(function(){
			$(this).click(function(){
				var parent = "";
				if($(this).attr("reply") != '-1')
					parent = $(this).attr("reply");

				var id = $("#id").val();
				var message = $(this).parent().parent().parent().parent().parent().children("#commentMessage").val();
				$.ajax({
					url: "http://plychannel.com/Include/postComment.php",
					type: 'post',
					data: { parent:parent, id:id, message:message },
					success: function(data){
						if (data == "DONE")
						{
							changeCommentSelection();
						}
						else
						{
							var messageForComment = $(this).parent().parent().parent().parent().parent().children("#commentPostTemp");
							messageForComment.html(data);
							messageForComment.slideDown().delay(2000).slideUp();
						}
					}
				});
			});
		});
		$('[id=commentLikes]').each(function(){
			$(this).unbind("click");
			$(this).click(function(){

				$('[id=commentLikes]').each(function(){
					$(this).attr("class", "commentLikes");
				});

				$(this).attr("class", "commentLikesActive");
				var id = $(this).attr("number");
				var like = $(this).attr("like");
				$.ajax({
					url: "http://plychannel.com/Include/commentLiked.php",
					type: 'post',
					data: { id:id, like:like },
					success: function(data){
					}
				});
			});
		});
	}

	$("#LikeImage").click(function(){
		var id = $("#id").val(); 
		var like;
		if ($("#LikeImage").attr("src") == "http://plychannel.com/Images/Liked.png")
		{
			$("#LikeImage").attr("src", "http://plychannel.com/Images/Like.png");
			$("#DislikeImage").attr("src", "http://plychannel.com/Images/Dislike.png");
			like = '2';
		}
		else
		{
			$("#LikeImage").attr("src", "http://plychannel.com/Images/Liked.png");
			$("#DislikeImage").attr("src", "http://plychannel.com/Images/Dislike.png");
			like = '1';
		}

		$.ajax({
			url: "http://plychannel.com/Include/liked.php",
			type: 'post',
			data: { id:id, like:like },
			success: function(data){
			}
		});
	});
	$("#DislikeImage").click(function(){
		var id = $("#id").val();
		var like;
		if ($("#DislikeImage").attr("src") == "http://plychannel.com/Images/Disliked.png")
		{
			$("#LikeImage").attr("src", "http://plychannel.com/Images/Like.png");
			$("#DislikeImage").attr("src", "http://plychannel.com/Images/Dislike.png");
			like = '2';
		}
		else
		{
			$("#LikeImage").attr("src", "http://plychannel.com/Images/Like.png");
			$("#DislikeImage").attr("src", "http://plychannel.com/Images/Disliked.png");
			like = '0';
		}

		$.ajax({
			url: "http://plychannel.com/Include/liked.php",
			type: 'post',
			data: { id:id, like:like },
			success: function(data){
			}
		});
	});
	});

	$('[id=playlistSelected]').each(function(){
		$(this).click(function(){
			var playlist = $(this).attr("number");
			var videoID = $("#id").val();
			var totalVideos = $("#totalPlVideos_" + $(this).attr("number"));
			if ($("#tick_" + $(this).attr("number")).css("display") == "none")
			{
				$("#tick_" + $(this).attr("number")).css("display", "block");
				$.ajax({
					url: "http://plychannel.com/Include/addTo.php",
					type: 'post',
					data: { playlist:playlist, videoID:videoID },
					success: function(data){
						$("#AddToMessage").html(data);
						$("#AddToMessage").slideDown(200).delay(2500).slideUp(200);
						totalVideos.html(parseInt(totalVideos.html()) + 1);
					}
				});
			}
			else
			{
				$("#tick_" + $(this).attr("number")).css("display", "none");
				$.ajax({
					url: "http://plychannel.com/Include/removeFrom.php",
					type: 'post',
					data: { playlist:playlist, videoID:videoID },
					success: function(data){
						$("#AddToMessage").html(data);
						$("#AddToMessage").slideDown(200).delay(2500).slideUp(200);
						totalVideos.html(parseInt(totalVideos.html()) - 1);
					}
				});
			}
		});
	});
	

	$("#playlistCreate").click(function(){
		var playlist = $("#playlistTyped").val();
		var videoID = $("#id").val();
		var newPlaylist = $("#playlistPrivacySelected").val();
		$.ajax({
			url: "http://plychannel.com/Include/addTo.php",
			type: 'post',
			data: { playlist:playlist, videoID:videoID, newPlaylist:newPlaylist },
			success: function(data){
				$("#AddToMessage").html("<div class='alert alert-success'>Added to " + playlist + "</div>");
				$("#playlistChoser").prepend(data);
				$("#AddToMessage").slideDown(200).delay(2500).slideUp(200);

				$('[id=playlistSelected]').each(function(){
					$(this).unbind("click");
					$(this).click(function(){
						var playlist = $(this).attr("number");
						var videoID = $("#id").val();
						var totalVideos = $("#totalPlVideos_" + $(this).attr("number"));
						if ($("#tick_" + $(this).attr("number")).css("display") == "none")
						{
							$("#tick_" + $(this).attr("number")).css("display", "block");
							$.ajax({
								url: "http://plychannel.com/Include/addTo.php",
								type: 'post',
								data: { playlist:playlist, videoID:videoID },
								success: function(data){
									$("#AddToMessage").html(data);
									$("#AddToMessage").slideDown(200).delay(2500).slideUp(200);
									totalVideos.html(parseInt(totalVideos.html()) + 1);
								}
							});
						}
						else
						{
							$("#tick_" + $(this).attr("number")).css("display", "none");
							$.ajax({
								url: "http://plychannel.com/Include/removeFrom.php",
								type: 'post',
								data: { playlist:playlist, videoID:videoID },
								success: function(data){
									$("#AddToMessage").html(data);
									$("#AddToMessage").slideDown(200).delay(2500).slideUp(200);
									totalVideos.html(parseInt(totalVideos.html()) - 1);
								}
							});
						}
					});
				});
				
			}
		});
	});

	$("#videoReportButton").click(function(){
		var message = $("#videoReportMessage").val();
		var id = $("#id").val();

		$.ajax({
			url: "http://plychannel.com/Include/sendVideoReport.php",
			type: 'post',
			data: { id:id, message:message },
			success: function(data){
				$("#reportMessage").html(data);
				$("#reportMessage").slideDown(200).delay(2500).slideUp(200);
			}
		});
	});

function addslashes(string) 
{
    return string.replace(/\\/g, '\\\\').
        replace(/\u0008/g, '\\b').
        replace(/\t/g, '\\t').
        replace(/\n/g, '\\n').
        replace(/\f/g, '\\f').
        replace(/\r/g, '\\r').
        replace(/'/g, '\\\'').
        replace(/"/g, '\\"');
}

function resizeChannelVideo()
{
	if ($(window).width() > 1184 && $(window).height() > 900)
	{
		$("#plychannelVideoID").css('width', 1150 + 'px');
		$("#plychannelVideoID").css('height', 852 + 'px');

		$(".videoDetails").css('width', 1135 + 'px');
		$(".videoDetails").css('top', '-' + 80 + 'px');

		$(".detailsNext").css('width', 1135 + 'px');
		$(".detailsNext").css('top', '-' + 81 + 'px');

		$(".playlistBar").css('top', 66 + 'px');
		$("#playlistList").css('top', 107 + 'px');
		$("#playlistList").css('right', 'calc(50% - ' + 219 + 'px');
		$("#playlistList").css('height', 971 + 'px');

		$("#playlistTyped").css("width", 971 + "px");
	}
	else if ($(window).width() > 976 && $(window).height() > 700)
	{
		$("#plychannelVideoID").css('width', 949 + 'px');
		$("#plychannelVideoID").css('height', 703 + 'px');

		$(".videoDetails").css('width', 934 + 'px');
		$(".videoDetails").css('top', '-' + 70 + 'px');

		$(".detailsNext").css('width', 934 + 'px');
		$(".detailsNext").css('top', '-' + 71 + 'px');

		$(".playlistBar").css('top', 55 + 'px');
		$("#playlistList").css('top', 96 + 'px');
		$("#playlistList").css('right', 'calc(50% - ' + 118.5 + 'px');
		$("#playlistList").css('height', 583 + 'px');

		$("#playlistTyped").css("width", 770 + "px");
	}
	else if ($(window).width() > 765 && $(window).height() > 500)
	{
		$("#plychannelVideoID").css('width', 715 + 'px');
		$("#plychannelVideoID").css('height', 529 + 'px');

		$(".videoDetails").css('width', 700 + 'px');
		$(".videoDetails").css('top', '-' + 50 + 'px');

		$(".detailsNext").css('width', 700 + 'px');
		$(".detailsNext").css('top', '-' + 51 + 'px');

		$(".playlistBar").css('top', 44 + 'px');

		$("#playlistList").css('top', 85 + 'px');
		$("#playlistList").css('right', 'calc(50% - ' + 2 + 'px');
		$("#playlistList").css('height', 437 + 'px');

		$("#playlistTyped").css("width", 536 + "px");
	}
	else
	{
		$("#plychannelVideoID").css('width', 735 + 'px');
		$("#plychannelVideoID").css('height', 544 + 'px');

		$(".videoDetails").css('width', 720 + 'px');
		$(".videoDetails").css('top', '-' + 50 + 'px');

		$(".detailsNext").css('width', 720 + 'px');
		$(".detailsNext").css('top', '-' + 51 + 'px');

		$(".playlistBar").css('top', 45 + 'px');
		$("#playlistList").css('top', 85 + 'px');
		$("#playlistList").css('height', 449 + 'px');

		$("#playlistTyped").css("width", 536 + "px");
	}
}

$("#playlistLister").click(function(){
	if ($("#playlistList").css('display') == "none")
	{
		$("#playlistList").slideDown(700);
	}
	else
	{
		$("#playlistList").slideUp(700);
	}
});

$("#SendVideoToEmail").click(function(){
	var id = $("#id").val();
	var emails = $("#emailingThisVideoTo").val();
	$.ajax({
		url: "http://plychannel.com/Include/sendVideo.php",
		type: 'post',
		data: { emails:emails, id:id },
		success: function(data){
			$("#SentVideoEmail").html(data);
			$("#SentVideoEmail").slideDown(500).delay(2000).slideUp(500);
		}
	});
});

resizeChannelVideo();