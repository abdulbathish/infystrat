<?php
	include "../db/mysql.php";
	include "../db/config.php";
	
	$id = $_GET[cid];
	$sql = q("select * from contactus where cid ='$id'",$dbconnect);
	$r = f($sql);
	$cnt=nr($sql);
	//$fullname=$r['fname']." ".$r['lname'];
	$fullname=$r['fname'];

	$sel_mail = "select * from contactus_mail where active='1' and id='1'";
	$res_mail = q($sel_mail,$dbconnect);
	$row_mail = f($res_mail);
	$admin_mail=$row_mail['mail_from'];
	$mail_subject=$row_mail['mail_subject'];
	$mail_content =$row_mail['mail_content'];
	$mail_footer =$row_mail['mail_footer'];
		   
	if(isset($_POST[btnSubmit]))
	{
			$fullname=$r['fname'];
			$email=$r['email'];
			$subject=$_POST['subject'];
			$message=$_POST['message'];
		
		  //------ mail content for commentor -----
			$mailto_commentor = $email;
			$subject_commentor = $subject;						
			
			$mailmessage_commentor .= "<table width='98%' cellspacing=0 cellpadding=3>
			<tr><td colspan='2' style='font-family:Verdana; font-size:12px;'><b>Dear ".$fullname.",</b></td></tr>
			<tr><td colspan='2' height='10'></td></tr>
			<tr><td colspan='2' style='font-family:Verdana; font-size:12px;'>".$message."</td></tr>
			<tr><td colspan='2' height='15'></td></tr>
			<tr><td colspan='2' style='font-family:Verdana; font-size:12px;'><b>".$mail_footer."</b></td></tr>
			<tr><td height='10' colspan='2'></td></tr>
			<tr><td colspan='2' style='font-family:Verdana; font-size:12px;'><b>---</b><br />This mail is send from <a href='http://www.c-duck.com/'>www.c-duck.com</a></td></tr>
			</table>";
						
			$headers_commentor = "MIME-Version: 1.0\r\n"; 
			$headers_commentor .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			$headers_commentor .="From: GYR Technology<$admin_mail>\r\n";
			
					
		$mail = @mail($mailto_commentor,$subject_commentor,$mailmessage_commentor,$headers_commentor);
		if($mail)
		{
			echo "<script>
					alert('Mail Sent successfully');
					window.close();
				  </script>";
		}
		else
		{
			echo "<script>
					alert('Mail Not Sent, Try Again !');
				  </script>";
		} 
	
	}//if(isset($_POST[btnSubmit]))
	 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Contact us reply form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/stylesheet_admin.css" rel="stylesheet" type="text/css">
<script>
function  nullChk()
{
	var subject =  document.getElementById("subject").value;
	var msg = document.getElementById("message").value;
	
	if(subject=="")
	{
		alert("Please Enter subject.");
		document.getElementById("subject").focus();
		return false;
	}
	
	if(msg=="")
	{
		alert("Please Enter Messsage.");
		document.getElementById("message").focus();
		return false;
	}
}//function  nullChk()
	 
</script>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
 <form method="post" action="" onSubmit="return nullChk();">
 <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="table_class">
  <tr>
    <td height="22" align="left" class="table_title">Contact us reply form</td>
  </tr>
  <tr>
    <td>&nbsp; </td>
  </tr>
  <tr>
    <td align="center" class="txt_content"> 
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
			<tr class='table_row'>
			<td width="13%"><b>To </b></td>
			<td width="87%"><?php echo ucwords($fullname);?></td>
		</tr>
		
		<tr class='table_row'>
			<td nowrap="nowrap"><b>Email </b></td>
            <td><?php echo $r['email'];?></td>
		</tr>
		
		<tr class='table_row'>
			<td><b>Subject </b></td>
			<td><input type="text" name="subject" id="subject" size="65" maxlength="150" value=""></td>
		</tr>
		
		<tr class='table_row'>
			<td><b>Message </b></td> 
			<td>
				<textarea name="message" id="message" rows="7" cols="62"></textarea>
			</td> 
		</tr>
		<tr class='table_row'>
			<td>&nbsp; </td><td><input type="submit" name="btnSubmit" value=" Send Mail " class="input-button" onClick="return nullChk();"> </td> 
		</tr>
		</table> 
	
	</td>
  </tr>
</table>
</form>
</body>
</html>
