<?php
if($access_page==0) { header("location:index.php"); die(); }

//if (isset($_SESSION['token']) && $_GET['token'] == $_SESSION['token'] )
//{

	if($_POST['pageid']!=''){
		$pageid = $_POST['pageid'];
	}else{
		$pageid = $_GET['pageid'];
	}

  $id=$_GET['id'];
  $singleid=$_GET['singleid'];

  if($singleid =='') {
	  $count=count(explode(",",$id))-1;
	  $split=explode(",",$id);
		  for($i=0;$i<=$count;$i++){
			  $newsid=$split[$i];
				
				$sel_img = "select picture,pdf from general_pages where id='$newsid'";
				$res_img = q($sel_img,$dbconnect);
				$row_img = f($res_img);
				$img_name = $row_img['picture'];
				$pdf_name = $row_img['pdf'];

				@unlink("../general_image/".$pdf_name);
				@unlink("../general_image/".$img_name);
				@unlink("../general_image/thumb0/".$img_name);
				
				$sql_file="delete from tbl_page_file where page_id=$newsid";
				q($sql_file,$dbconnect);

				$sql = "delete from general_pages where id=$newsid";
				q($sql,$dbconnect);
				
			  }
	  }else {
			$sel_img = "select picture,pdf from general_pages where id='$singleid'";
			$res_img = q($sel_img,$dbconnect);
			$row_img = f($res_img);
			$img_name = $row_img['picture'];
			$pdf_name = $row_img['pdf'];

			@unlink("../general_image/".$pdf_name);
			@unlink("../general_image/".$img_name);
			@unlink("../general_image/thumb0/".$img_name);
			
			$sql_file="delete from tbl_page_file where page_id=$singleid";
			q($sql_file,$dbconnect);

			$sql = "delete from general_pages where id=$singleid";
			q($sql,$dbconnect);
	}
?>
<script language="JavaScript">
  window.location="index.php?page=subpage_list&msg=Sub page deleted successfully.&pageid=<?php echo $pageid;?>";
</script>
<?php //} ?>