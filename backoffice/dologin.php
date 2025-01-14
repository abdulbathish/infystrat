<?php
	session_start();
	include "../db/mysql.php";
	include "../db/config.php";
	
	$loginname1 = mysql_real_escape_string($_POST['txtname']);
	$pwd = mysql_real_escape_string($_POST['txtpass']);

	if(isset($_SESSION['loginattempt']) && $_SESSION['loginattempt']!="")
	{
		$loginattempt=$_SESSION['loginattempt'];
	}else{
		$loginattempt=0;
	}	
	$ipaddr=$_SERVER['REMOTE_ADDR'];
		
	$sql = "select * from admin where uname ='".chop($loginname1)."' and password ='".md5($pwd)."'";
	
	$rs = q($sql,$dbconnect);
	if(nr($rs)>0)
	{
			
		while($row = f($rs)) 
		{			 	
			$adminname = $row['uname'];
			$id = $row['id'];
			$grpid=$row['id'];
			$user_type=$row['user_type'];		
			
			$_SESSION['adminname'] =$adminname;
			$_SESSION['loginname'] =$adminname;
			$_SESSION['admin_id'] =$id;
			$_SESSION['grpid'] =$grpid;
			$_SESSION['user_type'] =$user_type;
			
			@header("location: index.php?id=$id&grpid=$grpid");
		}
	}
	else
	{
		$loginattempt=$loginattempt+1;
		//session_register("loginattempt");
		$_SESSION['loginattempt'] =$loginattempt;
		
		$sel_mail = "select * from contactus_mail where id=1 and active='1'";
		$res_mail = q($sel_mail,$dbconnect);
		$row_mail = f($res_mail);
		$admin_mail=$row_mail['mail_from'];
		$mail_subject=$row_mail['mail_subject'];
		$mail_content =$row_mail['mail_content'];
		$mail_footer =$row_mail['mail_footer'];
			
		if($_SESSION['loginattempt']>=5)
		{
			if(isset($_SESSION['inserted_id']) && $_SESSION['inserted_id']!=''){
				$instsql="Update `loginfailed_ip`  set `ipaddress`='$ipaddr' ,`wrong_attempt_cnt`='$loginattempt' where id=".$_SESSION['inserted_id'];
				q($instsql,$dbconnect);
				$inserted_id=$_SESSION['inserted_id'];	
			}else
			{
				$instsql="INSERT INTO `loginfailed_ip` (`id` ,`ipaddress` ,`wrong_attempt_cnt`)VALUES ('' , '$ipaddr', '$loginattempt');";
				q($instsql,$dbconnect);
				$inserted_id=mysql_insert_id();
				//session_register("inserted_id");
				$_SESSION['inserted_id'] =$inserted_id;
			}				
			$exp_name = explode("/",$_SERVER["SCRIPT_NAME"]);
			$cnt = count($exp_name);
			$link =  "http://".$_SERVER["HTTP_HOST"]."/";
				
			$mailmessage .= "<table width='80%' cellspacing=0 cellpadding=3>
			<tr><td colspan='2'>Hello,</td></tr>
			<tr><td colspan='2'>&nbsp;</td></tr>
			<tr><td colspan='2'>$mail_content</td></tr>";
			
			$mailmessage .= "
			<tr><td width='30%' colspan='2'>Details are as follows:</td></tr>
			<tr><td width='30%' colspan='2'><strong>Username : </strong>$loginname1</td></tr>
			<tr><td width='30%' colspan='2'><strong>IP Address : </strong>$ipaddr</td></tr>
			<tr><td width='30%' colspan='2'><strong>Number Of wrong attempt : </strong>$loginattempt</td></tr>";
				
			$mailmessage .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			<tr><td colspan='2'>&nbsp;</td></tr>
			<tr><td colspan='2'>&nbsp;</td></tr>
			<tr><td colspan='2'><strong>$mail_footer</strong> </td></tr>
			</table>";
			
			$headers = "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			$headers .="From:<$admin_mail> \r\n";
		
			
			@mail($admin_mail,$mail_subject,$mailmessage,$headers);
		}
	?>
		<script language="javascript">
			alert("Check your username and password");
			window.location = "index.php?msg=Check%20your%20username%20or%20password";
		</script>
		
	<?php
	}
?>