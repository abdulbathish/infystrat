<?php
if($access_adminuser==0) { header("location:index.php"); die(); }
	$id = $_GET['id'];
	$sql = "select * from admin_user_type where id=$id";
	$qry = q($sql,$dbconnect);
	$result = f($qry);
	 
	$user_name = $result['user_name']; 
		  
	if(!empty($result['postdate'])){
		$postdate = date('d M Y',$result['postdate']);
	}else{
		 $postdate = date('d-M-Y');
	}

	//$exp_user_access  = explode(",",$result[user_access]);
	$exp_user_access  = explode("-",$result[user_access]);
	 
	
	include $htmlfile."admin_user_type_details.html";
?>
