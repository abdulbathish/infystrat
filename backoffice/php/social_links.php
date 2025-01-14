<?php
	if($access_social==0) { header("location:index.php"); die(); }
	
	$sel_link = "select * from social_links where status='1'";
	$res_link = q($sel_link,$dbconnect);
	$res_row = f($res_link);
	
	if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] )
	{ 
		if(isset($_POST['btnSubmit']))
		{
			$link_title1 = utf8_encode($_POST['link_title1']);
			$link_title2 = utf8_encode($_POST['link_title2']);
			$link_title3 = utf8_encode($_POST['link_title3']);
			$link_title4 = utf8_encode($_POST['link_title4']);
			$link_title5 = utf8_encode($_POST['link_title5']);
			
			$link_url1 = utf8_encode($_POST['link_url1']);
			$link_url2 = utf8_encode($_POST['link_url2']);
			$link_url3 = utf8_encode($_POST['link_url3']);
			$link_url4 = utf8_encode($_POST['link_url4']);
			$link_url5 = utf8_encode($_POST['link_url5']);
								  
			
			$qu = q("update social_links set link_title1='$link_title1' ,link_url1='$link_url1', link_title2='$link_title2' ,link_url2='$link_url2',link_title3='$link_title3' ,link_url3='$link_url3',link_title4='$link_title4' ,link_url4='$link_url4' ,link_title5='$link_title5' ,link_url5='$link_url5'  where id='1'",$dbconnect);
			
			if($qu)
			{
				echo "<script>window.location='index.php?page=social_links&msg=Social Links Updated Successfully'</script>";
			}
			else
			{
				echo "<script>window.location='index.php?page=social_links&msg_error=Social Links Updation Failed'</script>";
			}
		
		}// if(isset($_POST['btnSubmit']))		
	}
	include $htmlfile."social_links.html";
?>
