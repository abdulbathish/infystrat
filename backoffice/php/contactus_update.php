<?php
if($access_contact==0) { header("location:index.php"); }
if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] )
{   
	$id= $_POST['id']; 
	
	$cname = utf8_encode($_POST['cname']); 
	$email = $_POST['email']; 
	$telno = $_POST['telno']; 
	$stay_updated = $_POST['stay_updated']; 
	$comment = utf8_encode($_POST['comment']); 	
	
	if($id == '') {
    	$sql = "insert into contactus(cid,
									cname, 
									email,
									comment,
									stay_updated,
									contact_date
									) 
							
							values('',
								   '$cname', 
								   '$email',
								   '$comment',
								   '$stay_updated',
								   now())";  
		} 
		else 
		{ 
			$sql = "update contactus set cname='$cname',email='$email',comment='$comment',stay_updated='$stay_updated',contact_date=now() where cid='$id'";
		}	

if(q($sql,$dbconnect))
{
	if($id==''){
?>
	 <script language="JavaScript">
	  window.document.location.href="index.php?page=contactus&msg=Contact added successfully";
	 </script>
<?php } else { ?>
	<script language="JavaScript">
	  window.document.location.href="index.php?page=contactus&msg=Contact updated successfully";
	 </script>
<?	}
 }
 else
 {
?>  
 <script language="JavaScript">
  window.document.location.href="index.php?page=contactus&msg_error=Contact add failed";
  </script>
<?php
 }
}
?>
