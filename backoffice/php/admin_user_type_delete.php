<?php
//if($access_adminuser==0) { header("location:index.php"); die(); }    
//if (isset($_SESSION['token']) && $_GET['token'] == $_SESSION['token'] )
//{ 
  $catid=$_GET['id'];
  $singleid = $_GET['singleid'];
  if($singleid =='') {
	  $count=count(explode(",",$catid))-1;
	  $split=explode(",",$catid);
	  for($i=0;$i<=$count;$i++){
		  $newsid=$split[$i];
		  if($newsid!='undefined')
		  {
		  	$sql = "delete from admin_user_type where id=$newsid";
			q($sql,$dbconnect);
		  }
	  } 
	  }else {
		$sql = "delete from admin_user_type where id=$singleid";
		q($sql,$dbconnect);
    }
?>
<script language="JavaScript">
  window.document.location.href="index.php?page=admin_user_type_list&msg=User Type deleted successfully";
</script>
<?php //} ?>