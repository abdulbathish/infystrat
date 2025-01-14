<?php
if($access_mailmasters==0) { header("location:index.php"); die(); }
	
	$userid_chkid=$_POST['userid1'];
	$useract_ststus=$_POST['status1'];		

	if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] && $userid_chkid !="")
	{
		if($useract_ststus==1)
		$set_sts = 0;
		else
		$set_sts = 1; 
		
		q("update contactus_mail set active='$set_sts' where id='$userid_chkid'",$dbconnect);
	}  
	
	//--------- Pagination code -------//
	$sql1="select * from contactus_mail order by id ASC";
	$rowsperpage = 15;
	$website = "index.php?page=contactus_mail_list";
	$pagination = new Pagination($sql1, $rowsperpage, $website, $dbconnect);
	$pagination->setPage($_GET['page1']);
	$pageList =$pagination->showPage();
	
	
	$name=$_POST['search'];
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" and mail_subject like '%".$name."%'" : $wheresql.=" mail_subject like '%".$name."%'");
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" or mail_content like '%".$name."%'" : $wheresql.=" mail_content like '%".$name."%'");
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" or mail_from like '%".$name."%'" : $wheresql.=" mail_from like '%".$name."%'");
	
	if($name !='') 
	{
		$sql = "select * from contactus_mail where ".$wheresql." order by id ASC limit " . $pagination->getLimit() . ", " . $rowsperpage;
	} 
	else
	{
		$sql = "select * from contactus_mail order by id ASC limit " . $pagination->getLimit() . ", " . $rowsperpage;
	}
		
	$qry = q($sql,$dbconnect);
	$start_limit=$pagination->getLimit();
	$cols= $start_limit+1;
	$test1=1;
	if(nr($qry) > 0 ) 
	{
		while ($result = f($qry))
		{		
			if($result['active']==1){
				$active='<img src="images/tick.png" alt="Published" border="0">';
			} else {
				$active='<img src="images/publish_x.png" alt="Unpublished" border="0">';
			}	
		
		 if ($test1==1)
		 {
		 $text .= "<tr class='table_row1'>
		 <td align='center' height=22>$cols</td>
		 <td align='left' height=22><a href='index.php?page=contactus_mail_details&id=$result[id]' class='top_lightblue_link'>$result[mail_subject] </a></td>
		<td align='left' height=22><a href='index.php?page=contactus_mail_details&id=$result[id]' class='top_lightblue_link'>$result[mail_from] </a></td>	 
		 <td align='center' height=22><a href='#' onClick='fnStatus(".$result[id].",".$result[active].")' class='top_lightblue_link'>$active </a> </td>
		 <td align='center'><input name='checkList[]' type='checkbox' value='$result[id]'><input name='checkList[]' type='hidden' value='0'></td></tr>";
		 $test1=0;
		 }
		 else
		 {
		 $text .= "<tr class='table_row'>
		 <td align='center' height=22>$cols</td>
		 <td align='left' height=22><a href='index.php?page=contactus_mail_details&id=$result[id]' class='top_lightblue_link'>$result[mail_subject] </a></td>
		 <td align='left' height=22><a href='index.php?page=contactus_mail_details&id=$result[id]' class='top_lightblue_link'>$result[mail_from] </a></td>
		 <td align='center' height=22><a href='#' onClick='fnStatus(".$result[id].",".$result[active].")' class='top_lightblue_link'>$active </a> </td>
		 <td align='center'><input name='checkList[]' type='checkbox' value='$result[id]'><input name='checkList[]' type='hidden' value='0'></td></tr>";
		 $test1=1;
		 }	
		 $cols++;
		}
	} else {
		$text .= "<tr class='table_row'><td align='center' height=22 colspan='5'><font color='red'>No such a record found.</font></td></tr>";
	}
	include $htmlfile."contactus_mail_list.html";
?>
