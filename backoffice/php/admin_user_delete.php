<?php
if($access_adminuser==0) { header("location:index.php"); die(); }
if (isset($_SESSION['token']) && $_GET['token'] == $_SESSION['token'] )
{ 
  $id=$_GET['id'];
  $singleid=$_GET['singleid'];
  if($singleid =='') {
	  $count=count(explode(",",$id))-1;
	  $split=explode(",",$id);
	  for($i=0;$i<=$count;$i++){
		  $newsid=$split[$i];
		  if($newsid!='undefined'){
		  $sql = "delete from admin where id=$newsid";
		  q($sql,$dbconnect);
		  }
	  }
	  } else {
	   $sql = "delete from admin where id=$singleid";
	   q($sql,$dbconnect);
    }
?> 
<script language="JavaScript">
  window.document.location.href="index.php?page=admin_user_list&msg=Admin user deleted successfully";
</script>
<?php } ?> 