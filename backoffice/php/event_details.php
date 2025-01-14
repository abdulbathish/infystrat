<?php
	$id = $_GET['id'];
	
	if(isset($_GET['dimg']))
	{
		$sel_img = "select fld_picture from tbl_event where fld_id='$_GET[dimg]'";
		$res_img = q($sel_img,$dbconnect);
		$row_img = f($res_img);
		$img_name = $row_img[0];
		 
		@unlink("../event_images/".$img_name);
		@unlink("../event_images/thumb0/".$img_name);
		@unlink("../event_images/thumb1/".$img_name);
		q("update tbl_event set fld_picture='' where fld_id='$_GET[dimg]'",$dbconnect);
		echo "<script>window.location='index.php?page=event_details&id=$_GET[dimg]'</script>";
	}
	
	$sql = "select * from tbl_event where fld_id=$id";
	$qry = q($sql,$dbconnect);
	$result = f($qry);
	
	$subject = $result['fld_name'];
	$intro_text = $result['fld_intro_text'];
	if($result['fld_date']=='0000-00-00' || $result['fld_date']==''){
		$eventdate = '';
	}else{
		$eventdate = date("d-m-Y",strtotime($result['fld_date']));
	}
	$description = $result['fld_description'];
	
	if($result['fld_picture']!="" && file_exists("../event_images/$result[fld_picture]"))
	{
		$imgpath = "../event_images/$result[fld_picture]";
		$img_name = "<a href='javascript:void(0)' onClick='showImage(\"$imgpath\")'>View Image</a>&nbsp;|&nbsp;<a href='index.php?page=event_details&id=$id&dimg=$id'>Delete Image</a>";
	   
	}

	include $htmlfile."event_details.html";
?>