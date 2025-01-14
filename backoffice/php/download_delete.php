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
			$sel_img = "select fld_pdf from tbl_download where fld_id='$newsid'";
			$res_img = q($sel_img,$dbconnect);
			$row_img = f($res_img);
			$pdf_name = $row_img['fld_pdf'];
			
			@unlink("../download_images/".$pdf_name);
			
		  	$sql = "delete from tbl_download where fld_id=$newsid";
			q($sql,$dbconnect);
		  }
	  }
  } 
  else 
  {
		$sel_img = "select fld_pdf from tbl_download where fld_id='$singleid'";
		$res_img = q($sel_img,$dbconnect);
		$row_img = f($res_img);
		$pdf_name = $row_img['fld_pdf'];
		
		@unlink("../download_images/".$pdf_name);
			
  		$sql = "delete from tbl_download where fld_id=$singleid";
  		q($sql,$dbconnect);
  }
   
  
?>
<script language="JavaScript">
	window.document.location.href="index.php?page=download_list&msg=Download deleted successfully";
</script>
