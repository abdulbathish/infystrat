<?php
	global $id,$singleid,$newsid,$i,$count,$split,$rs_image,$sel_prod,$res_prod,$row_prod,$del_product,$res_delproduct,$sel_subcat,$res_subcat,$del_subcategory,$res_subcategory,$sel_model,$res_model,$row_model,$del_model,$res_model,$rs_image;
  
	$id=$_GET['id'];
	$singleid=$_GET['singleid'];
	$jobid = $_GET['job_id'];	
	if($singleid =='') 
	{
		$count=count(split(",",$id))-1;
		$split=split(",",$id);
		
		for($i=0;$i<=$count;$i++)
		{
			$newsid=$split[$i];
			if($newsid!='undefined')
			{
				$sel_img = "select picture,job_cv from tbl_job_apply where id='$newsid'";
				$res_img = q($sel_img,$dbconnect);
				$row_img = f($res_img);
				$img_name = $row_img['picture'];
				$img_name1 = $row_img['job_cv'];
				
				@unlink("../job_images/".$img_name);
				@unlink("../job_images/".$img_name1);
				
				$sql = "delete from tbl_job_apply where id=$newsid";
				q($sql,$dbconnect);
		  }//if($newsid!='undefined')
	  }//for($i=0;$i<=$count;$i++)
	
	  }else 
	  {
		$sel_img = "select picture,job_cv from tbl_job_apply  where id='$singleid'";
		$res_img = q($sel_img,$dbconnect);
		$row_img = f($res_img);
		$img_name = $row_img['picture'];
		$img_name1 = $row_img['job_cv'];
		
		@unlink("../job_images/".$img_name);
		@unlink("../job_images/".$img_name1);
		
		$sql = "delete from tbl_job_apply where id=$singleid";
		q($sql,$dbconnect);
		  
    }//else if($singleid =='') 
		
?>
<script language="JavaScript">
  window.document.location.href="index.php?page=career_job_apply_list&job_id=<?php echo $jobid;?>&msg=Job Application Deleted Successfully";
</script>
