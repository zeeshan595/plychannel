$("[id=EmailCheck]").each(function(){
	$(this).change(function(){
		var id = $(this).attr("number");
		var email = '0';
		if ($(this).is(':checked'))
			email = '1';
		$.ajax({
        url: "PHP/changesubscription.php",
        type: 'post',
        data: { id:id, email: email },
        success: function(data){
        	console.log(data);
          }
        });
	});
})

$("[id=unsub]").each(function(){
	$(this).click(function(){
		var id = $(this).attr("number");
		//Unsubscribe
		$.ajax({
        url: "PHP/unsubscribe.php",
        type: 'post',
        data: { id:id },
        success: function(data){
        	console.log(data);
          }
        });
		//Remove from UI
		$("[id=subItem]").each(function(){
			if ($(this).attr("number") == id)
			{
				$(this).remove();
			}
		})
	});
})