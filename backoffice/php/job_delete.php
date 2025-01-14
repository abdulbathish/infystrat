<?php
if($access_job==0) { header("location:index.php"); }
if (isset($_SESSION['token']) && $_GET['token'] == $_SESSION['token'] )
{  
  $catid=$_GET[id];
  $singleid=$_GET[singleid];
  if($singleid =='') {
	  $count=count(split(",",$catid))-1;
	  $split=split(",",$catid);
	  for($i=0;$i<=$count;$i++){
		  $newsid=$split[$i];
		  if($newsid!='undefined')
		  {
		  	
			$sel_img = "select picture from tbl_job where fld_id='$newsid'";
			$res_img = q($sel_img,$dbconnect);
			$row_img = f($res_img);
			$img_name = $row_img['picture'];
			
			@unlink("../job_images/thumb1/".$img_name);
			@unlink("../job_images/thumb0/".$img_name);
			@unlink("../job_images/".$img_name);
			
			$sql = "delete from tbl_job where fld_id=$newsid";
			q($sql,$dbconnect);
		  }
	  }
	  } else {
		 
		$sel_img = "select picture from tbl_job where fld_id='$singleid'";
		$res_img = q($sel_img,$dbconnect);
		$row_img = f($res_img);
		$img_name = $row_img['picture'];
		
		@unlink("../job_images/thumb0/".$img_name);
		@unlink("../job_images/".$img_name);
		
		$sql = "delete from tbl_job where fld_id=$singleid";
		q($sql,$dbconnect);
    }

	
?>
<script language="JavaScript">
  window.document.location.href="index.php?page=job_list&msg= Record deleted successfully";
</script>
<?php } ?>