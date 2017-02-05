function checkToolBar()
{
	if ( $(window).width() > 1600)
	{
		$("#menuButton").attr("class", "menuButtonRed");
		$(".sideBar").fadeIn(100);
	}
	else
	{
		$("#menuButton").attr("class", "menuButton");
		$(".sideBar").fadeOut(100);
	}
}

$("#menuButton").click(function(){
	if ($(this).attr("class") == "menuButtonRed")
	{
		$(this).attr("class", "menuButton");
		$(".sideBar").fadeOut(100);
	}
	else
	{
		$(this).attr("class", "menuButtonRed");
		$(".sideBar").fadeIn(100);
	}
});

$(".item").each(function(){
	$(this).mouseenter(function() {
		$(this).children(".normal").css("display", "none");
		$(this).children(".hover").css("display", "inline-block");
	});
	$(this).mouseleave(function() {
		$(this).children(".normal").css("display", "inline-block");
		$(this).children(".hover").css("display", "none");
	});
});


$( window ).resize(function() {
  checkToolBar();
});
checkToolBar();

$(".search").css("width", "calc(100% - 450px)");
$("#searchBar").css("width", "calc(100% - 90px)");