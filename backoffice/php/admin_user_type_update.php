<?php
if($access_adminuser==0) { header("location:index.php"); die(); }
if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] )
{  
  $id= $_POST['id']; 
  $user_name = $_POST['user_name']; 

  $user_access="";		
	
  for($i=0;$i<sizeof($_POST['user_access']);$i++)
  {
		$user_access=$user_access.$_POST['user_access'][$i]."-";
  }
		
  //$user_access = substr($user_access,0,strlen($user_access)-1);
   
  if($id == '')
  {
	$sql = "insert into admin_user_type(id,user_name,user_access,status,postdate) values('','$user_name','$user_access','1',now())";  
  } 
  else 
  { 
	$sql = "update admin_user_type set user_name='$user_name', user_access='$user_access', postdate=now() where id='$id'";
  }	
 
if(q($sql,$dbconnect))
{
	if($id==''){
?>
	 <script language="JavaScript">
	  window.document.location.href="index.php?page=admin_user_type_list&msg=User Type added successfully";
	 </script>
<?php } else { ?>
	<script language="JavaScript">
	  window.document.location.href="index.php?page=admin_user_type_list&msg=User Type updated successfully";
	 </script>
<?php	}
 }
 else
 {
?>  
 <script language="JavaScript">
  window.document.location.href="index.php?page=admin_user_type_list&msg_error=User Type add failed";
  </script>
<?php
 }
}
?>
