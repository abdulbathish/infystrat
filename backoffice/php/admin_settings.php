<?php

	$admin_id = $_SESSION['admin_id'];
	$sel_admin = "select * from admin where id='$admin_id'";
	$res_admin = q($sel_admin,$dbconnect);
	$res_row = f($res_admin);
			
	if(isset($_POST['btnSubmit']))
	{
	  $np = $_POST['new_pwd'];
	  $mdnp = md5($_POST['new_pwd']);				  
	  $qu = q("update admin set password='$mdnp' where id=$admin_id",$dbconnect);
			
		if($qu)
		{
			echo "<script>window.location='index.php?page=admin_settings&msg=Password Updated Successfully'</script>";
		}
		else
		{
			echo "<script>window.location='index.php?page=admin_settings&msg_error=Password Not Updated Successfully'</script>";
		}
			
	}// if
	include $htmlfile."admin_settings.html";
?>
