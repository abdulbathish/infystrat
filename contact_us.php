<?php include "top_head.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$captcha_error = !PhpCaptcha::Validate($_POST['captcha']);
	}
	else
	{
		$captcha_error = false;
	}
	if(!$captcha_error)
	{
		if($_POST['btns_maincontactsubmit']!="")
		{
			$sel_mail = "select * from contactus_mail where active='1' and id='1'";
			$res_mail = q($sel_mail,$dbconnect);
			$row_mail = f($res_mail);
			$admin_mail=$row_mail['mail_from'];
			$mail_subject=$row_mail['mail_subject'];
			$mail_content =$row_mail['mail_content'];
			$mail_footer =$row_mail['mail_footer'];

			$name = htmlentities(trim($_POST['txtname']),ENT_QUOTES);
			$email = htmlentities(trim($_POST['txtemail']),ENT_QUOTES);
			$subject = htmlentities(trim($_POST['txtsubject']),ENT_QUOTES);
			$user_message = htmlentities(trim($_POST['txtmessage']),ENT_QUOTES);
			$phone = htmlentities(trim($_POST['txtphone']),ENT_QUOTES);

			$sql = "INSERT INTO `contactus` (`cid`,`fname`,`email`,`subject`,`phone`,`message`, `contact_date`)
        		 VALUES (NULL ,'$name','$email','$subject','$phone','$user_message',now())";
			if(q($sql,$dbconnect))
			{
				//Email to contact person, Thank you email
				$message1 = "<table border='0' width='98%'>
				<tr><td colspan='2' style='font-family:Verdana; font-size:12px;'><b>Dear $name,</b></td></tr>
				<tr><td height='15' colspan='2'></td></tr>
				<tr><td colspan='2' style='font-family:Verdana; font-size:12px;'>$mail_content</td></tr>		
				<tr><td height='15' colspan='2'></td></tr>
				<tr><td colspan='2' style='font-family:Verdana; font-size:12px;'><b>$mail_footer </b></tr>
				<tr><td height='15' colspan='2'></td></tr>
				<tr><td colspan='2' style='font-family:Verdana; font-size:12px;'><b>---</b><br />This mail is send from the contact form on <a href='http://www.infystrat.com'>www.infystrat.com</a></td></tr>
				</table>";

				$subject1=$mail_subject;
				$to1=$email; 
				
				$headers1  = "MIME-Version: 1.0" . "\r\n";
				$headers1 .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
				$headers1 .= "From: InfyStrat<$admin_mail>\r\n";

				@mail($to1, $subject1, $message1, $headers1);

				// main to admin
				$message = "<table border='0' width='98%'>
				<tr><td colspan='2' style='font-family:Verdana; font-size:12px;'><b>Contact Information</b></td></tr>
				<tr><td height='15' colspan='2'></td></tr>
				<tr><td width='15%' style='font-family:Verdana; font-size:12px;'><b>Name :</b> </td><td style='font-family:Verdana; font-size:12px;'>$name</td></tr>
				<tr><td style='font-family:Verdana; font-size:12px;'><b>Email : </b></td><td style='font-family:Verdana; font-size:12px;'>$email</td></tr>
				<tr><td style='font-family:Verdana; font-size:12px;'><b>Phone :</b> </td><td style='font-family:Verdana; font-size:12px;'>$phone</td></tr>
				<tr><td style='font-family:Verdana; font-size:12px;'><b>Subject : </b></td><td style='font-family:Verdana; font-size:12px;'>$subject</td></tr>
				<tr><td style='font-family:Verdana; font-size:12px;'><b>Message :</b> </td><td style='font-family:Verdana; font-size:12px;'>$user_message</td></tr>
				<tr><td height='15' style='font-family:Verdana; font-size:12px;' colspan='2'></td></tr>
				<tr><td colspan='2' style='font-family:Verdana; font-size:12px;'><b>$mail_footer </b></tr>
				<tr><td height='15' colspan='2'></td></tr>
				<tr><td colspan='2' style='font-family:Verdana; font-size:12px;'><b>---</b><br />This mail is send from the contact form on <a href='http://www.infystrat.com'>http://www.infystrat.com</a></td></tr>
				</table>";

				$subject="Contact Form | InfyStrat";
				$to=$admin_mail;

				$headers  = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
				//$headers .= "From: $name<$email>\r\n";
				$headers .= "From: Infystrat<$admin_mail>\r\n";	
				$headers .= "Reply-To: $name<$email>\r\n";

				@mail($to, $subject, $message, $headers);
				
				if($permaval=="title")
				{
					$page_file_details=f(q("select prefix from tbl_other_files where page_id=8",$dbconnect));
					//$hurl_string=make_url($permaval,$page_title,$url_title,$page_file_details['page_file_name'],$page_id);
					$re_url=$page_file_details['prefix']."/y";
					//$re_url="contact_us.php?pageid=$_GET[pageid]&msg=n";
				}else
				{
					$re_url="contact_us.php?msg=y";
				}
			?>
				<script language="javascript">
					window.location.href="<?php echo $base_url; ?><?php echo $re_url; ?>";
				</script>
			 <?php	}else{
				if($permaval=="title")
				{
					$page_file_details=f(q("select prefix from tbl_other_files where page_id=8",$dbconnect));
					$re_url=$page_file_details['prefix']."/n";
				}else
				{
					$re_url="contact_us.php?msg=n";
				}
			 ?>
				<script language="javascript">
					window.location.href="<?php echo $base_url; ?><?php echo $re_url; ?>";
				</script>
		  <?php
			}
		}
	}

	if($captcha_error)
	{
		$name = $_POST['txtname'];
		$email = $_POST['txtemail'];
		$subject = $_POST['txtsubject'];
		$message_comments = $_POST['txtmessage'];
		$phone = $_POST['txtphone'];
	} ?>
<script>
function checkval()
{
	var name = document.getElementById("txtname").value;
	var email = document.getElementById("txtemail").value;
	var emailpat = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i ;
	var subject = document.getElementById("txtsubject").value;
	var message = document.getElementById("txtmessage").value;
	var captcha = document.getElementById("captcha-form").value;
	if(name==''){
		hideErrors();
		document.getElementById("Ename").style.display="inline";
		document.getElementById("txtname").focus();
		return false;
	}
	if(email==''){
		hideErrors();
		document.getElementById("Eemail").style.display="inline";
		document.getElementById("txtemail").focus();
		return false;
	}
	if(emailpat.test(email)==false ){
		hideErrors();
		document.getElementById("EVemail").style.display="inline";
		document.getElementById("txtemail").focus();
		return false;
	}
	if(subject==''){
		hideErrors();
		document.getElementById("Esubject").style.display="inline";
		document.getElementById("txtsubject").focus();
		return false;
	}
	if(message==''){
		hideErrors();
		document.getElementById("Emessage").style.display="inline";
		document.getElementById("txtmessage").focus();
		return false;
	}
	if(captcha==''){
		hideErrors();
		document.getElementById("Ecode").style.display="inline";
		document.getElementById("captcha-form").focus();
		return false;
	}
	document.contact_form.submit();
}
function hideErrors()
{
	document.getElementById("Ename").style.display="none";
	document.getElementById("Eemail").style.display="none";
	document.getElementById("EVemail").style.display="none";
	document.getElementById("Esubject").style.display="none";
	document.getElementById("Emessage").style.display="none";
	document.getElementById("Ecode").style.display="none";
}
</script>

<!-- Body BEGIN -->
<body class="corporate">
   
   <!-- Header Start -->
		<?php include "header.php";?>
   <!-- Header END -->


    <div class="main">
      <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?php echo $base_url;?>index.php">Home</a></li>
            <li class="active"><?php echo $page_title;?></li>
        </ul>
        <div class="row margin-bottom-40">
          <!-- BEGIN CONTENT -->
          <div class="col-md-12">
            <div class="content-page">
              <div class="row">
                
                <div class="col-md-6 col-sm-6">
                  <h2>Our Contacts</h2>
                  <?php echo $page_info_desc;?> 
                </div>

				<div class="col-md-6 col-sm-6 margin-bottom-40 sidebar2">
                  <h2>Contact Form</h2>
                  <p><?php echo $page_intro_text;?></p>

				  <?php if($_GET["msg"]=="y"){ ?>
						<div class="succ">Your message has been sent successfully.</div>
						<div style="clear:both"></div>
					<?php }else if($_GET["msg"]=="n"){ ?>
						<div class="error">Sorry, message send failed. Try again.</div>
						<div style="clear:both"></div>
					<?php }	?>
                  
                  <!-- BEGIN FORM-->
				  <form role="form" id="contact_form" method="POST" name="contact_form" onsubmit="return checkval();">
					<input type="hidden" id="btns_maincontactsubmit" name="btns_maincontactsubmit" value="main_contactsubmit">
					  <div class="form-group">
						<label for="career-name">Name<span style="color:#FF0100">*</span></label>
						<input type="text" class="form-control" id="txtname" type="text" name="txtname" value="<?php echo $name;?>" maxlength="60">
						<div id="Ename" class="div_error">Name should not be blank.</div>
					  </div>
					  <div class="form-group">
						<label for="career-name">Email<span style="color:#FF0100">*</span></label>
						<input type="text" class="form-control" id="txtemail" type="email" name="txtemail" value="<?php echo $email;?>" maxlength="60">
						<div id="Eemail" class="div_error">Email should not be blank.</div>
						<div id="EVemail" class="div_error">Please enter valid email.</div>
					  </div>
					  <div class="form-group">
						<label for="career-name">Subject<span style="color:#FF0100">*</span></label>
						<input type="text" class="form-control" id="txtsubject" type="text" name="txtsubject" value="<?php echo $subject;?>" maxlength="100">
						<div id="Esubject" class="div_error">Subject should not be blank.</div>
					  </div>
					  <div class="form-group">
						<label for="career-name">Phone</label>
						<input type="text" class="form-control" id="txtphone" type="text" name="txtphone" value="<?php echo $phone;?>" maxlength="25" onkeyup="checkNumber(txtphone);">
					  </div>
					  <div class="form-group">
						<label for="career-name">Comments<span style="color:#FF0100">*</span></label>
						<textarea type="text" class="form-control" id="txtmessage" name="txtmessage"><?php echo $message_comments;?></textarea>
						<div id="Emessage" class="div_error">Comments should not be blank.</div>
					  </div>	
					  
					   <div class="form-group">
						<label for="career-name">Verification Code<span style="color:#FF0100">*</span></label><div style="clear:both"></div>
						  <span style="float:left;border:0;">
							<input name="captcha" id="captcha-form" autocomplete="off" maxlength="5" type="text" class="form-control" style="width:80px;"/>
						  </span>
							<span style="float:left; margin:0 0 10px 5px;">
								<div id="captchaimg">
									<img src="<?php echo $base_url;?>phpcaptcha/visual-captcha.php" class="captcha_img" alt="code" width="<?php echo CAPTCHA_WIDTH; ?>" height="<?php echo CAPTCHA_HEIGHT; ?>" />
								</div>
								<a href="javascript:newCaptchaJS();" id="change-image" class="captcha_link">Not readable? Change text.</a>
							</span>
							<div style="clear:both"></div>
						  <div id="Ecode" class="div_error" <?php if ($captcha_error){ echo "style='display: inline;'";} else { echo "style='display: none;'";} ?>>Please enter same verification code.</div>
					  </div>	

					  <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Submit Message</button>
                  </form>
                  <!-- END FORM-->
                </div>

				<?php
					$sel_map = "select * from google_map";
					$res_map = q($sel_map,$dbconnect);
					$row_map = f($res_map);
				?>

				<div class="col-md-12">
                  <div id="map" class="gmaps" style="height:400px;"><?php echo $row_map['gmap_details'];?></div>
                </div>

              </div>
            </div>
          </div>
          <!-- END CONTENT -->
        </div>
      </div>
    </div>

    <!-- START FOOTER -->
	<?php include "footer.php"; ?>
   <!-- END FOOTER -->
</body>
<!-- END BODY -->
</html>