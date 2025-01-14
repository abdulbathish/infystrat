<?php
if($access_partners==0) { header("location:index.php"); }
  $catid=$_GET['id'];
  $singleid=$_GET['singleid'];
  if($singleid =='')
  {
	  $count=count(explode(",",$catid))-1;
	  $split=explode(",",$catid);
	  for($i=0;$i<=$count;$i++)
	  {
		  $newsid=$split[$i];
		  if($newsid!='undefined')
		  {
		  	$sel_img = "select picture from partners where id='$newsid'";
			$res_img = q($sel_img,$dbconnect);
			$row_img = f($res_img);
			$img_name = $row_img['picture'];
			
			@unlink("../category_images//".$img_name);
			@unlink("../category_images/thumb0/".$img_name);
			
			$sql = "delete from partners where id=$newsid";
			q($sql,$dbconnect);
		  }
	  }
  } 
  else 
  {	
  		$sel_img = "select picture from partners where id='$singleid'";
		$res_img = q($sel_img,$dbconnect);
		$row_img = f($res_img);
		$img_name = $row_img['picture'];
			
		@unlink("../category_images//".$img_name);
		@unlink("../category_images/thumb0/".$img_name);
		
  		$sql = "delete from partners where id=$singleid";
  		q($sql,$dbconnect);
  }
   
  
?>
<script language="JavaScript">
	window.document.location.href="index.php?page=partners_list&msg=Product Category deleted successfully";
</script>
