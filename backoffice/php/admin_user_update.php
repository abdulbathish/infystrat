<?php
//if($access_adminuser==0) { header("location:index.php"); die(); }
if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] )
{ 
	if($_POST['id'] !=""){
		$id= $_POST['id'];
	} else { 
		$id= $_GET['id'];
	} 
	
	$uname  = $_POST['uname'];
		
	if($id !=""){
		$sql_chklogin = "select * from admin where id=$id";
		$res_chklogin = q($sql_chklogin,$dbconnect);
		$row_chklogin = f($res_chklogin);
		$dbusername=$row_chklogin['uname'];
		$dbuserpwd=$row_chklogin['password'];
	}
	
    if($id !=""){
		if($_POST['pwd']==$dbuserpwd){
			$encpwd  = $dbuserpwd;
		} else {
			$pwd  = $_POST['pwd'];	
			$encpwd  = md5($_POST['pwd']);
		}
	} else {
		if($_POST['pwd']!=""){
			$pwd  = $_POST['pwd'];	
			$encpwd  = md5($_POST['pwd']);
		}
	}	
	
	
	//echo $oripwd;
	
	$pwd1  = $_POST['pwd'];
	$type1  = $_POST['type1'];
	$contact_us1  = $_POST['contact_us'];
	$full_name1  = $_POST['pname'];
	$email1  = $_POST['email'];
	
	$status1  = $_POST['status'];
	
	$sql_login = "select * from admin where uname ='$uname'";
	$res_login = q($sql_login,$dbconnect);
	$row_login = f($res_login);
	$cnt_login = nr($res_login);

	
	if($id =='')
	{			
		if ( $cnt_login > 0 )
		{
		   ?>
			  <script language="JavaScript">
				window.document.location.href="index.php?page=admin_user_details&id=<?php echo $id?>&msg_error=Username already exists!";
			 </script>
		  <? 
		} else {
			$sql = "insert into admin(id,full_name,email,uname,password,user_type,status)values('','$full_name1','$email1','$uname','$encpwd','$type1','$status1')";
		}
	} else {
		if($dbusername != $uname) 
		{
			if ( $cnt_login > 0 )
			{
			   ?>
				  <script language="JavaScript">
					window.document.location.href="index.php?page=admin_user_details&id=<?php echo $id?>&msg_error=Username already exists!";
				 </script>
			<? 
			} else {
				$sql = "update admin set full_name='$full_name1', email='$email1', uname='$uname', password='$encpwd', user_type='$type1', status='$status1' where id='$id'";
			}
		} else {
			$sql = "update admin set full_name='$full_name1', email='$email1', uname='$uname', password='$encpwd', user_type='$type1', status='$status1' where id='$id'";
		}
	}	
	//echo $sql;
	//die();
if(q($sql,$dbconnect))
{
	if($id==''){
?>
	 <script language="JavaScript">
	  window.document.location.href="index.php?page=admin_user_list&msg=Admin user added successfully";
	 </script>
<?php } else { ?>
	<script language="JavaScript">
	  window.document.location.href="index.php?page=admin_user_list&msg=Admin user updated successfully";
	 </script>
<?	}
 }
 else
 {
?>  
 <script language="JavaScript">
  window.document.location.href="index.php?page=admin_user_list&msg_error=Admin user add failed";
  </script>
<?php
 }
}
?>
