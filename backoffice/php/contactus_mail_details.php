<?php
if($access_mailmasters==0) { header("location:index.php"); die(); }
	$id = $_GET['id'];
	$sql = "select * from contactus_mail where id = $id";
	$qry = q($sql,$dbconnect);
	$result = f($qry);
	
	$mail_subject = $result['mail_subject'];
	$mail_content = $result['mail_content'];
	$mail_from = $result['mail_from'];
	$mail_footer = $result['mail_footer'];
	$active = $result['active'];
	
	include $htmlfile."contactus_mail_details.html";
?>
