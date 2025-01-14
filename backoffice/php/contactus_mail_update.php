<?php
if($access_mailmasters==0) { header("location:index.php"); die(); }

if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] )
{ 
	$id = $_POST['id'];
	$mail_subject = str_replace("'","&rsquo;",$_POST['mail_subject']);
	$mail_from = $_POST['mail_from'];
	$mail_content = str_replace("'","&rsquo;",$_POST['mail_content']);
	$mail_footer = str_replace("'","&rsquo;",$_POST['mail_footer']);
	$active = $_POST['active'];
	
	if($id == '') {
		$sql = "insert into `contactus_mail`(`id`,`mail_subject`,`mail_content`,`mail_from`,`mail_footer`,`active`) values('','$mail_subject','$mail_content','$mail_from','$mail_footer','$active')";
	} else {
		$sql = "update `contactus_mail` set `mail_subject`='$mail_subject',`mail_content`='$mail_content',`mail_from`='$mail_from',`mail_footer`='$mail_footer', `active`='$active' where `id`='$id'";
	}

if(q($sql,$dbconnect))
{
	if($id==''){
?>
	 <script language="JavaScript">
	  window.document.location.href="index.php?page=contactus_mail_list&msg=Contact Us Mail Added Successfully";
	 </script>
<?php } else { ?>
	<script language="JavaScript">
	  window.document.location.href="index.php?page=contactus_mail_list&msg=Contact Us Mail Updated successfully";
	 </script>
<?	}
 }
 else
 {
?>  
 <script language="JavaScript">
  window.document.location.href="index.php?page=contactus_mail_list&msg_error=Contact Us Mail Add Failed";
  </script>
<?php
 }
}
?>
