<?php
	ob_start(); 
	session_start();
	//error_reporting(0);

	global $phpfile,$htmlfile,$ParentPage, $Recs_Per_Page , $Total_Recs , $lowerLimit, $CssClass, $CssClass1,$search_url,$pageList,$text;
	include "../db/mysql.php";
	include "../db/config.php";
	
	$phpfile="php/";
	include("fckeditor/fckeditor.php");
	$htmlfile="";
	$photos="../photos/";  
	//include_once "datetime.php";
	include_once "datetime.php";
	include_once "php/pagination.php";
	include_once "../db/pagination.php";
	//$today_date = mktime (0,0,0,date("m"),date("d"),date("Y"));
	$today_date = time();
	
	//-------- select site name ------
	$sel_header_txt = "select site_name,footer_text from site_configuration where id='1'";
	$res_header_txt = q($sel_header_txt,$dbconnect);
	$row_header_txt = f($res_header_txt);
	$footer_text = $row_header_txt['footer_text'];

	$login_username = $_SESSION['loginname'];
	$login_userid = $_SESSION['admin_id'];
	
	$sel_chkaccess = "select * from admin_user_type where id='$_SESSION[user_type]'";
	$res_chkaccess = q($sel_chkaccess,$dbconnect);
	$nr_chkaccess = nr($res_chkaccess);
	$row_chkaccess = f($res_chkaccess);		
	$exp_chkacces_module = explode("-",$row_chkaccess['user_access']);	
	
	$access_adminuser=0;
	$access_page=0;
	$access_mailmasters=0;
	$access_banner=0;
	$access_event=0;
	$access_job=0;
	$access_partners=0;
	$access_location=0;
	
	$access_reviews=0;
	$access_booking=0;
	$access_book_now=0;
   	$access_contact=0;
	$access_friendcontact=0;
    $access_newsletter==0;	
	$access_social=0;
	$access_pwd=0;
	$access_siteconf=0;
	$access_project=0;
	$access_home_section=0;
	$access_customer=0;
	$access_order=0;
	
	
	if($_SESSION["loginname"]!="")
	{  
		for($k=0;$k<count($exp_chkacces_module);$k++)
		{	
			if($exp_chkacces_module[$k] =='admin_user_mgn'){ $access_adminuser=1; }
			if($exp_chkacces_module[$k] =='slideshow_mgn'){ $access_banner=1; }
			if($exp_chkacces_module[$k] =='event_mgn'){ $access_home_section=1; }
			if($exp_chkacces_module[$k] =='recruitment_mgn'){ $access_job=1; }
			if($exp_chkacces_module[$k] =='partners_mgn'){ $access_partners=1; }
			if($exp_chkacces_module[$k] =='master_mgn'){ $access_mailmasters=1; }
			if($exp_chkacces_module[$k] =='location_mgn'){ $access_location=1; }
			
			if($exp_chkacces_module[$k] =='page_mgn'){ $access_page=1; }
			if($exp_chkacces_module[$k] =='led_mgn'){ $access_media=1; }
			if($exp_chkacces_module[$k] =='partners_mgn'){ $access_reviews=1; }
			if($exp_chkacces_module[$k] =='booking_mgn'){ $access_booking=1; }
			if($exp_chkacces_module[$k] =='booking_btn_mgn'){ $access_book_now=1; }
            if($exp_chkacces_module[$k] =='contact_mgn'){ $access_contact=1; }
			if($exp_chkacces_module[$k] =='friendcont_mgn'){ $access_friendcontact=1; }
         	if($exp_chkacces_module[$k] =='social_mgn'){ $access_social=1; }
			if($exp_chkacces_module[$k] =='password_mgn'){ $access_pwd=1; }
			if($exp_chkacces_module[$k] =='site_mgn'){ $access_siteconf=1; }
			if($exp_chkacces_module[$k] =='newsletter_mgn'){ $access_newsletter=1; }

			if($exp_chkacces_module[$k] =='customer_mgn'){ $access_customer=1; }
			if($exp_chkacces_module[$k] =='order_mgn'){ $access_order=1; }
		}
	}		

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<script language="javascript">
function CalcKeyCode(aChar) {
  var character = aChar.substring(0,1);
  var code = aChar.charCodeAt(0);
  return code;
}

function checkNumber(val) {
  var strPass = val.value;
  var strLength = strPass.length;
  var lchar = val.value.charAt((strLength) - 1);
  var cCode = CalcKeyCode(lchar);
  if (cCode < 48 || cCode > 57 ) {
    var myNumber = val.value.substring(0, (strLength) - 1);
    val.value = myNumber;
  }
  return false;
}
</script>
<head>
<title><?php echo utf8_decode($row_header_txt['site_name']); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

 <!-- favion -->
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
  <!-- apple touch icon -->
  <link rel="apple-touch-icon" href="favicon.ico">
  <!-- Loading Css -->

<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jsval.js"></script>

<script language="javascript" src="php/ajax_req.js"></script>
<script language="javascript" src="js/datetimepicker.js"></script>
<!-- DATE Picker JS -->
<script src="src/js/jscal2.js"></script>
<script src="src/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />
<!-- DATE Picker JS Ends-->
<link href="css/pagination.css" rel="stylesheet" type="text/css" />

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="form1" method="Post">
<input type="hidden" name="LangID" value="">
</form>
	<?php
		
		if($_SESSION['admin_id']!="")
		{		
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left"><?php include "header.php"; ?></td>
      </tr>
      <tr>
        <td valign="top" id="content_inner"><table width="100%" border="0" cellspacing="3" cellpadding="3">
		<tr>
		<td width="24%" valign="top" id="content_inner">
		<?php include "sidebar.php" ?>		</td>
		<td width="76%" valign="top" id="content_inner"> 
		<?php
		
		if(!isset($_GET['page']))
		{
			include $phpfile."adminhome.php";				
		}
		else
		{
			include $phpfile.$_GET['page'].".php";				
		}
		?>		</td>
		</tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top"><?php include "footer.php"; ?></td>
      </tr>
    </table></td>
  </tr>
</table>

	<?php
		
		}
	else
		{
			include $phpfile."login.php";
		}
	?>		
</body>
</html>