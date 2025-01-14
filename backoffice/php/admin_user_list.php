<?php
if($access_adminuser==0) { header("location:index.php"); die(); }
	
	$userid_chkid=$_POST['userid1'];
	$useract_ststus=$_POST['status1'];		

	if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] && $userid_chkid !="")
	{
		if($useract_ststus==1)
		$set_sts = 0;
		else
		$set_sts = 1; 
		
		q("update admin set status='$set_sts' where id='$userid_chkid'",$dbconnect);
	}     

	$name=$_POST['search'];
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" and uname like '".$name."%'" : $wheresql.=" uname like '".$name."%'");
	
	if($name !='') 
	{
		$sql1 = "select * from admin where ".$wheresql." order by id desc";
	} 
	else
	{
		$sql1 = "select * from admin order by id desc";
	}
	
	$rowsperpage = 20;
	$website = "index.php?page=admin_user_list";
	$pagination = new Pagination($sql1, $rowsperpage, $website, $dbconnect);
	$pagination->setPage($_GET['page1']);
	$pageList =$pagination->showPage();
	
	if($name !='') 
	{
		$sql = "select * from admin where ".$wheresql." order by id desc limit " . $pagination->getLimit() . ", " . $rowsperpage;
	} 
	else
	{
		$sql = "select * from admin order by id desc limit " . $pagination->getLimit() . ", " . $rowsperpage;
	}
	$qry = q($sql,$dbconnect);
	$cols=1;
	$test1=1;
	if(nr($qry) > 0 ) 
	{
		while ($result = f($qry))
		{		
			if($result['status']==1)
			{
				$status="<img src='images/tick.png' title='Click here to dectivate' border=0>";
			} 
			else 
			{
				$status="<img src='images/publish_x.png' title='Click here to activate' border=0>";
			}	
			
			//----- select user type ----
			$sel_usertype = "select user_name from admin_user_type where id='$result[user_type]'";
			$res_usertype = q($sel_usertype,$dbconnect);
			$row_usertype = f($res_usertype);
			if($row_usertype['user_name']!=""){
				$usertype = $row_usertype['user_name'];
			}else{
				$usertype =" -- ";
			}	

		if ($test1==1)
		 {
		 $text .= "<tr class='table_row1'>
		 <td align='center' height=22>&nbsp;$cols</td>
		 <td align='left' height=22>&nbsp;<a href='index.php?page=admin_user_details&id=$result[id]' class='top_lightblue_link'>&nbsp;$usertype</a></td> 
		 <td align='left' height=22>&nbsp;<a href='index.php?page=admin_user_details&id=$result[id]' class='top_lightblue_link'>&nbsp;$result[full_name]</a></td> 
		 <td align='left' height=22>&nbsp;<a href='index.php?page=admin_user_details&id=$result[id]' class='top_lightblue_link'>&nbsp;$result[uname]</a></td> 
		 <td align='center' height=22>&nbsp;<a href='#' onClick='fnStatus(".$result[id].",".$result[status].")' class='top_lightblue_link'>$status</a></td>
		 <td align='center'><input name='checkList[]' type='checkbox' value='$result[id]'><input name='checkList[]' type='hidden' value='0'></td>
		 </tr>";
		 $test1=0;
		 }
		 else
		 {
		 $text .= "<tr class='table_row'>
		 <td align='center' height=22>&nbsp;$cols</td>
		 <td align='left' height=22>&nbsp;<a href='index.php?page=admin_user_details&id=$result[id]' class='top_lightblue_link'>&nbsp;$usertype</a></td> 
		 <td align='left' height=22>&nbsp;<a href='index.php?page=admin_user_details&id=$result[id]' class='top_lightblue_link'>&nbsp;$result[full_name]</a></td> 
		 <td align='left' height=22>&nbsp;<a href='index.php?page=admin_user_details&id=$result[id]' class='top_lightblue_link'>&nbsp;$result[uname]</a></td> 
		 <td align='center' height=22>&nbsp;<a href='#' onClick='fnStatus(".$result[id].",".$result[status].")' class='top_lightblue_link'>$status</a></td>
		 <td align='center'><input name='checkList[]' type='checkbox' value='$result[id]'><input name='checkList[]' type='hidden' value='0'></td>
		 </tr>";
		 $test1=1;
		 }	
		 $cols++;
		}
	} else {
		$text .= "<tr class='table_row'><td align='center' height=22 colspan='4'><font color='red'>No such a record found.</font></td></tr>";
	}
	include $htmlfile."admin_user_list.html";
?>
