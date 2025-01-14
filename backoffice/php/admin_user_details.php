<?php
if($access_adminuser==0) { header("location:index.php"); die(); }
	$id = $_GET['id'];
	$sql = "select * from admin where id = $id";
	$qry = q($sql,$dbconnect);
	$result = f($qry);
	
	$full_name = $result['full_name'];
	$email = $result['email'];
	$uname = $result['uname'];
	$pwd = $result['password'];
	$type1 = $result['user_type'];	
	$status = $result['status'];
	
	include $htmlfile."admin_user_details.html";
?>
