<?php
	if($access_location==0) { header("location:index.php"); }
    global $gmap_insert,$sel_gmap,$res_gmap,$row_gmap,$gmap_details;
	if(isset($_POST["btn_submit"])!="")
	{
		$gmap_insert = "update google_map set gmap_details='$_POST[gmp_description]' where id='1'";
		if(q($gmap_insert, $dbconnect))
		{
			header("location: index.php?page=google_map_list&msg=Google Map code updated successfully");
		}else{
			header("location: index.php?page=google_map_list&msg_error=Google Map updation failed");
		}
	}
	//------- google map ------
	$sel_gmap = "select * from google_map where id='1'";
	$res_gmap = q($sel_gmap,$dbconnect);
	$row_gmap = f($res_gmap);
	
	$gmap_details = $row_gmap['gmap_details'];
	
	include $htmlfile."google_map_list.html";
?>
