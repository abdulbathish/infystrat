<?php  
if($access_adminuser==0) { header("location:index.php"); die(); }
	$id=$_GET['id'];
	$singleid=$_GET['singleid'];
	if($singleid =='')
	{
		$count=count(split(",",$id))-1;
		$split=split(",",$id);
		for($i=0;$i<=$count;$i++){
			$newsid=$split[$i];
			if($newsid!='undefined')
			{ 			
			$sql = "delete from user_authentication where id=$newsid";
			q($sql,$dbconnect);
			}
		}
	} else {
		$sql = "delete from user_authentication where id=$singleid";
		q($sql,$dbconnect);	
	}	
?>
<script language="JavaScript">
   window.location="index.php?page=user_authentication_list&msg=User Authentication deleted successfully.";
</script>
