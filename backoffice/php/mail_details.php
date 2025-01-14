<?php
 $id = $_GET[id];
 $sql = "select * from tblmail_message where fldid = '1'";
 $qry = q($sql,$dbconnect);
 $result = f($qry);

 $title = $result['fldtitle']; 
 $description1 = $result['flddescription'];
   
   if(isset($_POST[btnSave]))
   {
   			
			$sq = q("select * from tblmail_message",$dbconnect);
			if(nr($sq)>0)
			{
					 
					$tit = $_POST[title];
					$description = str_replace("'","&rsquo;",$_POST[ajaxfilemanager]);
					$sql = "update tblmail_message set fldtitle='$tit',flddescription='$description' where fldid='1'";
					
					$qu = q($sql,$dbconnect);
					
					if($qu)
					{
							$msg = "Mail content updated successfully";
							 echo "<script>window.location='index.php?page=mail_details&msg=$msg'</script>"; 
					}
					else
					{
							$msg = "Mail content not updated. Try again !";
							 echo "<script>window.location='index.php?page=mail_details&msg=$msg'</script>"; 
					}
			}
			else
			{
					 
					$tit = $_POST[title];
					$description = str_replace("'","&rsquo;",$_POST[description]);
					$qu = q("insert into tblmail_message (fldid,fldtitle,flddescription) values ('','$tit','$description')",$dbconnect);
					
					if($qu)
					{
							$msg = "Mail contents added successfully";
							 echo "<script>window.location='index.php?page=mail_details&msg=$msg'</script>"; 
					}
					else
					{
							$msg = "Mail contents not added. Try again !";
							 echo "<script>window.location='index.php?page=mail_details&msg=$msg'</script>"; 
					}
			}
   }
   
include $htmlfile."mail_details.html";
?>
