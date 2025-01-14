<?php
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
		  	$sel_img = "select fld_picture from tbl_event where fld_id='$newsid'";
			$res_img = q($sel_img,$dbconnect);
			$row_img = f($res_img);
			$img_name = $row_img['fld_picture'];
			
			@unlink("../event_images//".$img_name);
			@unlink("../event_images/thumb0/".$img_name);
			@unlink("../event_images/thumb1/".$img_name);
			
			$sql = "delete from tbl_event where fld_id=$newsid";
			q($sql,$dbconnect);
		  }
	  }
  } 
  else 
  {
		$sel_img = "select fld_picture from tbl_event where fld_id='$singleid'";
		$res_img = q($sel_img,$dbconnect);
		$row_img = f($res_img);
		$img_name = $row_img['fld_picture'];
		
		@unlink("../event_images//".$img_name);
		@unlink("../event_images/thumb0/".$img_name);
		@unlink("../event_images/thumb1/".$img_name);
			
  		$sql = "delete from tbl_event where fld_id=$singleid";
  		q($sql,$dbconnect);
  }
   
  
?>
<script language="JavaScript">
	window.document.location.href="index.php?page=event_list&msg=News and Event deleted successfully";
</script>
