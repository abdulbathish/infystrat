<?php
if($access_banner==0) { header("location:index.php"); die(); }
if (isset($_SESSION['token']) && $_GET['token'] == $_SESSION['token'] )
{       
  $catid=$_GET['id'];
  $singleid=$_GET['singleid'];
  if($singleid =='') {
	  $count=count(explode(",",$catid))-1;
	  $split=explode(",",$catid);
	  for($i=0;$i<=$count;$i++){
		  $newsid=$split[$i];
		  if($newsid!='undefined'){
		  
		    $sel_img = "select picture from home_banners where id='$newsid'";
			$res_img = q($sel_img, $dbconnect);
			$row_img = f($res_img);
			$img_name = $row_img[0];
			@unlink("../banner_images/thumb0/".$img_name);		
			@unlink("../banner_images/thumb1/".$img_name);
			@unlink("../banner_images/".$img_name);
		  
		  $sql = "delete from home_banners where id=$newsid";
		  q($sql, $dbconnect);
		  }
	  }
	  } else {
	    $sel_img = "select picture from home_banners where id='$singleid'";
		$res_img = q($sel_img, $dbconnect);
		$row_img = f($res_img);
		$img_name = $row_img[0];
		@unlink("../banner_images/thumb0/".$img_name);		 
		@unlink("../banner_images/thumb1/".$img_name); 		
		@unlink("../banner_images/".$img_name);
		
	   $sql = "delete from home_banners where id=$singleid";
	   q($sql, $dbconnect);
    }
	
?>
<script language="JavaScript">
  window.document.location.href="index.php?page=homebanner_list&msg=Slideshow Banner deleted successfully";
</script>
<?php }	?>

