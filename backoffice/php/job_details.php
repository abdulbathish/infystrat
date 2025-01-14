<?php
if($access_job==0) { header("location:index.php"); }

	if(isset($_GET['dimg']))
	{
		$sel_img = "select picture from tbl_job where fld_id='$_GET[dimg]'";
		$res_img = q($sel_img,$dbconnect);
		$row_img = f($res_img);
		$img_name = $row_img[0];
		 
		@unlink("../job_images/".$img_name);
		@unlink("../job_images/thumb0/".$img_name);
		@unlink("../job_images/thumb1/".$img_name);
		q("update tbl_job set picture='',picture_alt='' where fld_id='$_GET[dimg]'",$dbconnect);
		echo "<script>window.location='index.php?page=job_details&id=$_GET[dimg]'</script>";
	}

	$id = $_GET['id'];
	$sql = "select * from tbl_job where fld_id=$id";
	$qry = q($sql,$dbconnect);
	$result = f($qry);
	$jobname = $result['fld_jobname'];
	$noofpos = $result['fld_position'];
	$location = $result['fld_location'];
	$description = $result['fld_description'];  
	
	$jobname_ne = $result['fld_jobname_ne'];
	$image_alt = $result['picture_alt'];
	$sethome = (($result['fld_sethome'] == 1)?'checked="checked"':"");
	//$active = (($result['fld_status'] == 1)?'checked="checked"':"");
	
	if($result['picture']!="" && file_exists("../job_images/$result[picture]"))
	{
		$imgpath = "../job_images/$result[picture]";
		$img_name = "<a href='javascript:void(0)' onClick='showImage(\"$imgpath\")'>View Image</a>&nbsp;|&nbsp;<a href='index.php?page=job_details&id=$id&dimg=$id'>Delete Image</a>";
	}
	
	include $htmlfile."job_details.html";
?>
