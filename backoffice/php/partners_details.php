<?php
	if($access_partners==0) { header("location:index.php"); }
	$id = $_GET['id'];
	
	if(isset($_GET['dimg']))
	{
		$sel_img = "select picture from partners where id='$_GET[dimg]'";
		$res_img = q($sel_img,$dbconnect);
		$row_img = f($res_img);
		$img_name = $row_img[0];
		 
		@unlink("../partners_images/".$img_name);
		@unlink("../partners_images/thumb0/".$img_name);
		@unlink("../partners_images/thumb1/".$img_name);
		@unlink("../partners_images/thumb2/".$img_name);
		q("update partners set picture='',picture_alt='' where id='$_GET[dimg]'",$dbconnect);
		echo "<script>window.location='index.php?page=partners_details&id=$_GET[dimg]'</script>";
	}	

	$sql = "select * from partners where id=$id";
	$qry = q($sql,$dbconnect);
	$result = f($qry);
	
	$partners_name = $result['partners_name'];
	$partners_name_ne = $result['partners_name_ne'];
	$url_title = $result['url_title'];
	$image_alt = $result['picture_alt'];
	$homeset = (($result['fld_showhome'] == 1)?'checked="checked"':"");

	if($result['picture']!="" && file_exists("../partners_images/thumb0/$result[picture]"))
	{
		$imgpath = "../partners_images/thumb0/$result[picture]";
	   $img_name = "<a href='javascript:void(0)' onClick='showImage(\"$imgpath\")'>View Image</a>&nbsp;|&nbsp;<a href='index.php?page=partners_details&id=$id&dimg=$id'>Delete Image</a>";
	   
	}

	if(!empty($result['postdate']))
		$postdate = date('d M Y',$result['postdate']);
	else {
	 $postdate = date('d-M-Y');
	}
  
	include $htmlfile."partners_details.html";
?>