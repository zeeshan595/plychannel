var emailCheck = false;
var LinkUrl = "http://plychannel.com/Include/registerChecks.php";

ChangeButtonStatus();
emailFunc();

$("#email").change(function(){
	emailFunc();
});

function emailFunc()
{
	email = $("#email").val();
	$.ajax({
		url: LinkUrl,
		type: 'post',
		data: { email:email },
		success: function(data){
			if (data == "fail")
			{
				$('#EmailCheck .well').html("Email is not in correct format.");
				$('#EmailCheck').css('display','block');
				emailCheck = false;
			}
			else
			{
				$('#EmailCheck').css('display','none');
				emailCheck = true;
			}

			$('#EmailCheck div').css('display','none');
			ChangeButtonStatus();
		}
	});
}

$('[id=glyphicon]').each(function(){
	var div = $(this).parent().children('div');
	$(this).mouseenter(function(){
		div.css('display','block');
	});
	$(this).mouseleave(function(){
		div.css('display','none');
	});
});

function ChangeButtonStatus()
{
	if (emailCheck)
	{
		$('button').attr('class', 'btn btn-lg btn-primary btn-block');
		$('button').removeAttr("disabled");
	}
	else
	{
		$('button').attr('class', 'btn btn-lg btn-default btn-block');
		$('button').attr("disabled","");
	}
}