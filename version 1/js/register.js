var userCheck = false;
var emailCheck = false;
var passwordCheck = false;
var matchCheck = false;
var LinkUrl = "http://plychannel.com/Include/registerChecks.php";

ChangeButtonStatus(false);

$("#user").change(function(){
	user = $("#user").val();
	$.ajax({
		url: LinkUrl,
		type: 'post',
		data: { user:user },
		success: function(data){
			if (data == "true")
			{
				$('#UserCheck').css('display','none');
				userCheck = true;
			}
			else if (data == "fail")
			{
				$('#UserCheck .well').html("You can't have that as your username.");
				$('#UserCheck').css('display','block');
				userCheck = false;
			}
			else
			{
				$('#UserCheck div').html("That username already exists.");
				$('#UserCheck').css('display','block');
				userCheck = false;
			}

			$('#UserCheck div').css('display','none');

			ChangeButtonStatus();
		}
	});
});

$("#email").change(function(){
	email = $("#email").val();
	$.ajax({
		url: LinkUrl,
		type: 'post',
		data: { email:email },
		success: function(data){
			if (data == "true")
			{
				$('#EmailCheck').css('display','none');
				emailCheck = true;
			}
			else if (data == "fail")
			{
				$('#EmailCheck .well').html("Email is not in correct format.");
				$('#EmailCheck').css('display','block');
				emailCheck = false;
			}
			else
			{
				$('#EmailCheck div').html("A user has already registered with that email.");
				$('#EmailCheck').css('display','block');
				emailCheck = false;
			}

			$('#EmailCheck div').css('display','none');
			ChangeButtonStatus();
		}
	});
});

$("#password").change(function(){
	password = $("#password").val();
	$.ajax({
		url: LinkUrl,
		type: 'post',
		data: { password:password },
		success: function(data){
			if (data == "true")
			{
				$('#PassCheck').css('display','none');
				passwordCheck = true;
			}
			else
			{
				$('#PassCheck .well').html("Password is not in correct format.<br /> It can contain letters, numbers and the following symbols<br />-_@#$%^&*()+");
				$('#PassCheck').css('display','block');
				passwordCheck = false;
			}

			$('#PassCheck div').css('display','none');
			ChangeButtonStatus();
		}
	});
});

$("#password2").change(function(){
	if ($("#password2").val() == $("#password").val())
	{
		$('#MatchCheck').css('display','none');
		matchCheck = true;
	}
	else
	{
		$('#MatchCheck .well').html("Passwords do not match.");
		$('#MatchCheck').css('display','block');
		matchCheck = false;
	}

	$('#MatchCheck div').css('display','none');
	ChangeButtonStatus();
});

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
	if (userCheck && emailCheck && passwordCheck && matchCheck)
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