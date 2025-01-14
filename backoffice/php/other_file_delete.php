<?php  

	$id=$_GET['id'];
	$singleid=$_GET['singleid'];
	if($singleid =='')
	{
		$count=count(explode(",",$id))-1;
		$split=explode(",",$id);
		for($i=0;$i<=$count;$i++){
			$newsid=$split[$i];
			if($newsid!='undefined')
			{ 			
			$sql = "delete from tbl_other_files where id=$newsid";
			q($sql,$dbconnect);
			}
		}
	} else {
		$sql = "delete from tbl_other_files where id=$singleid";
		q($sql,$dbconnect);	
	}	
?>
<script language="JavaScript">
   window.location="index.php?page=other_file_list&msg=Other file deleted successfully.";
</script>
