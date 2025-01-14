<?php
if($access_page==0) { header("location:index.php"); }

if(isset($_GET['dimg']))
{
	$sel_img = "select picture from general_pages where id='$_GET[dimg]'";
	$res_img = q($sel_img,$dbconnect);
	$row_img = f($res_img);
	$img_name = $row_img[0];
	 
	@unlink("../general_image/".$img_name); 
	@unlink("../general_image/thumb0/".$img_name); 
	q("update general_pages set picture='' where id='$_GET[dimg]'",$dbconnect);
	echo "<script>window.location='index.php?page=page_details&id=$_GET[dimg]'</script>";
}

	$id = $_GET['id'];
	$sql = "select * from general_pages where id = $id";
	$qry = q($sql,$dbconnect);
	$result = f($qry);
	
	$page_title = $result['page_title'];
	$browser_title = $result['browser_title'];
	
	$picture = $result['picture'];
	$image_alt = $result['image_alt'];
	$listing_title = $result['listing_title'];
	$url_title = $result['url_title'];
	$intro_text = $result['intro_text'];
	$description = $result['description'];
	$meta_keywords = $result['meta_keywords'];
  	$meta_description = $result['meta_description'];
	$page_subtitle = $result['page_subtitle'];
	$position = $result['position'];

	$url = $result['url'];
		
  if($result['picture']!="" && file_exists("../general_image/thumb0/$result[picture]"))
  {
        $imgpath = "../general_image/thumb0/$result[picture]";
	   
  	   $img_name = "<a href='javascript:void(0)' onClick='showImage(\"$imgpath\")'>View Image</a>&nbsp;|&nbsp;<a href='index.php?page=page_details&id=$id&dimg=$id'>Delete Image</a>";	   
  }		
	include $htmlfile."page_details.html";
?>