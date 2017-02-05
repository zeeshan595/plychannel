$("#EditVideos").click(function(){
	$("#managerForm").attr("action", "http://plychannel.com/edit");
	$("#formDefiner").val("Edit");
	$("#managerForm").submit();
});

$("#Download").click(function(){
	$("#managerForm").attr("action", "http://plychannel.com/download");
	$("#formDefiner").val("download");
	$("#managerForm").submit();
});

$("#AddTo").click(function(){
	$("#formDefiner").val("AddTo");
	$("#managerForm").submit();
});

$("#Delete").click(function(){
	$("#formDefiner").val("Delete");
	$("#managerForm").submit();
});

$("#AddToPlaylist").click(function(){
	$("#SubmitPlaylistData").val("0");
	$("#playlistForm").submit();
});

$("#CreatePlaylistButton").click(function(){
	$("#SubmitPlaylistData").val("1");
	$("#playlistForm").submit();
});

$("#checkAllBoxes").click(function(){
	$('[id=checkboxes]').each(function(){
		$(this).prop('checked', $("#checkAllBoxes").prop('checked'));
	});
});

$("#DeletePlaylist").click(function(){
	$("#formDefiner").val("Delete");
	$("#managerForm").submit();
});

$("#EditPlaylist").click(function(){
	$("#managerForm").attr("action", "http://plychannel.com/playlist?edit=1");
	$("#formDefiner").val("Edit");
	$("#managerForm").submit();
});