<?php
if($access_contact==0) { header("location:index.php"); }
if (isset($_SESSION['token']) && $_GET['token'] == $_SESSION['token'] )
{ 
  $id=$_GET[id];
  $singleid=$_GET[singleid];

  if($singleid =='') {
	  $count=count(explode(",",$id))-1;
	  $split=explode(",",$id);
	  for($i=0;$i<=$count;$i++){
		  $newsid=$split[$i];
		  if($newsid!='undefined'){
		  $sql = "delete from contactus where cid=$newsid";
		  q($sql,$dbconnect);
		  }
	  }
	  } else {
		$sql = "delete from contactus where cid=$singleid";
		q($sql,$dbconnect);
    }
	
?>
<script language="JavaScript">
  window.location="index.php?page=contactus&msg= Contact deleted successfully..";
</script>
<?php } ?>