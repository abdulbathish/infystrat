<?php
if($access_banner==0) { header("location:index.php"); die(); }

	$id = $_GET['id'];
	$sql = "select * from home_banners where id=$id";
	$qry = q($sql,$dbconnect);
	$result = f($qry);
	
	$pageid = $result['page_id'];
	$title = $result['title'];  
	$imagealt = $result['image_alt']; 
	$description = $result['description'];  
	

	if($result['picture']!="" && file_exists("../banner_images/$result[picture]"))
	{
	   $imgpath = "../banner_images/$result[picture]";
	   $img_name = "<a href='javascript:void(0)' onClick='showImage(\"$imgpath\")'>View Image</a>&nbsp;|&nbsp;<a href='index.php?page=homebanner_details&id=$id&dimg=$id'>Delete Image</a>";
	}
	
	if(!empty($result['postdate']))
		$postdate = date('d M Y',$result['postdate']);
	else {
		 $postdate = date('d-M-Y');
	}
	
	
	include $htmlfile."homebanner_details.html";
	
	//----- Code to delete the image -------
	if(isset($_GET['dimg']))
	{
		$sel_img = "select picture from home_banners where id='$_GET[dimg]'";
		$res_img = q($sel_img,$dbconnect);
		$row_img = f($res_img);
		$img_name = $row_img[0];
		 
		@unlink("../banner_images/thumb0/".$img_name);
		@unlink("../banner_images/thumb1/".$img_name);
		@unlink("../banner_images/".$img_name); 
		q("update home_banners set picture='' where id='$_GET[dimg]'",$dbconnect);
		echo "<script>window.location='index.php?page=homebanner_details&id=$_GET[dimg]'</script>";
	}
?>
