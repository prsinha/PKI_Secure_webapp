<html>
<head>
<title>Contact Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

.box {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	border: 1px solid #000000;

}

.bluebox {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bolder;
	color: #FFFFFF;
	background-color: #006699;
	border: 1px solid #000000;
}

.maincell {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	padding: 5px;
	border: 1px solid #006699;
}

.errmsg {
	font-family: "Courier New", Courier, mono;
	font-size: 12px;
	font-weight: bolder;
	color: #CC0000;
}

</style>
<script language="JavaScript">
function checkForm()
{
	var cname, cemail, csubject, cmessage;
	with(window.document.msgform)
	{
		cname    = sname;
		cemail   = email;
		csubject = subject;
		cmessage = message;
	}
	
	if(trim(cname.value) == '')
	{
		alert('Please enter your name');
		cname.focus();
		return false;
	}
	else if(trim(cemail.value) == '')
	{
		alert('Please enter your email');
		cemail.focus();
		return false;
	}
	else if(!isEmail(trim(cemail.value)))
	{
		alert('Email address is not valid');
		cemail.focus();
		return false;
	}
	else if(trim(csubject.value) == '')
	{
		alert('Please enter message subject');
		csubject.focus();
		return false;
	}
	else if(trim(cmessage.value) == '')
	{
		alert('Please enter your message');
		cmessage.focus();
		return false;
	}
	else
	{
		cname.value    = trim(cname.value);
		cemail.value   = trim(cemail.value);
		csubject.value = trim(csubject.value);
		cmessage.value = trim(cmessage.value);
		return true;
	}
}

/*
Strip whitespace from the beginning and end of a string
Input : a string
*/
function trim(str)
{
	return str.replace(/^\s+|\s+$/g,'');
}

/*
Check if a string is in valid email format. 
Returns true if valid, false otherwise.
*/
function isEmail(str)
{
	var regex = /^[-_.a-z0-9]+@(([-_a-z0-9]+\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i;
	return regex.test(str);
}
</script>
</head>

<body>
<?php

$errmsg  = ''; // error message
$sname   = ''; // sender's name
$email   = ''; // sender's email addres
$subject = ''; // message subject
$message = ''; // the message itself

if(isset($_POST['send']))
{
	$sname   = $_POST['sname'];
	$email   = $_POST['email'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	
	if(trim($sname) == '')
	{
		$errmsg = 'Please enter your name';
	} 
	else if(trim($email) == '')
	{
		$errmsg = 'Please enter your email address';
	}
	else if(!isEmail($email))
	{
		$errmsg = 'Your email address is not valid';
	}
	else if(trim($subject) == '')
	{
		$errmsg = 'Please enter message subject';
	}
	else if(trim($message) == '')
	{
		$errmsg = 'Please enter your message';
	}
	
	if($errmsg == '')
	{
		if(get_magic_quotes_gpc())
		{
			$subject = stripslashes($subject);
			$message = stripslashes($message);
		}	
		
		// the email will be sent here
		$to      = "email@yourdomain.com";
		
		// the email subject ( modify it as you wish )
		$subject = '[Contact] : ' . $subject;
		
		// the mail message ( add any additional information if you want )
		$msg     = "From : $sname \r\n " . $message;
		
		mail($to, $subject, $msg, "From: $email\r\nReply-To: $email\r\nReturn-Path: $email\r\n");
?>
<div align="center">Your message is sent. Click <a href="index.php">here</a> to 
  go back to homepage </div>
<?php
	}
}


if(!isset($_POST['send']) || $errmsg != '')
{
?>
<div align="center" class="errmsg"><?=$errmsg;?></div>
<form  method="post" name="msgform" id="msgform">
  <table width="500" border="0" align="center" cellpadding="2" cellspacing="1" class="maincell">
    <tr> 
      <td width="106">Your Name</td>
      <td width="381"><input name="sname" type="text" class="box" id="sname" size="30" value="<?=$sname;?>"></td>
    </tr>
    <tr> 
      <td>Your Email</td>
      <td><input name="email" type="text" class="box" id="email" size="30" value="<?=$email;?>"></td>
    </tr>
    <tr> 
      <td>Subject</td>
      <td><input name="subject" type="text" class="box" id="subject" size="30" value="<?=$subject;?>"></td>
    </tr>
    <tr> 
      <td>Message</td>
      <td><textarea name="message" cols="55" rows="10" wrap="OFF" class="box" id="message"><?=$message;?></textarea></td>
    </tr>
    <tr align="center"> 
      <td colspan="2"><input name="send" type="submit" class="bluebox" id="send" value="Send Message" onClick="return checkForm();"></td>
    </tr>
    <tr align="center"> 
      <td colspan="2">&nbsp;</td>
    </tr>	
    <tr align="left"> 
      <td colspan="2">If by any chance the form isn't working you can contact 
        me on <br>
		<script language="JavaScript">
		var addr = 'arman';
		var host = 'php-mysql-tutorial.com';
		var email = '<a href="mailto:' + addr + '@' + host + '">' + addr + '@' + host + '</a>';
		document.write(email);
		</script></td>
    </tr>
  </table>
</form>
<?php
}

function isEmail($email)
{
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i"
			,$email));
}
?>
<p>&nbsp;</p><div align="center">Copyright © 2004 <a href="http://www.php-mysql-tutorial.com">php-mysql-tutorial.com</a> 
</div>
<p>&nbsp;</p>
</body>
</html>
