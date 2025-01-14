<?php
if($access_adminuser==0) { header("location:index.php"); die(); }
	$name=trim($_REQUEST['search']);
	$userid_chkid=$_POST['userid1'];
	$useract_ststus=$_POST['status1'];		

	if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] && $userid_chkid !="")
	{
		if($useract_ststus==1)
		$set_sts = 0;
		else
		$set_sts = 1; 
		
		q("update admin_user_type set status='$set_sts' where id='$userid_chkid'",$dbconnect);
	}     
	
	//----- update menu order ---------
	if($_POST['updateOrder'] == "update")
	{
		$menuorder = $_POST['menuorder'];
		$menuid = $_POST['menuid'];
		if($menuorder!="" && $menuid!="")
		{
			$array_order = array_combine($menuid,$menuorder);
			foreach($array_order as $key => $value)
			{
				if($value)
				{
					$sql_update = "update admin_user_type set menu_order=$value where id = $key";
					$qry = q($sql_update,$dbconnect);
				}
			}
	    }
	}
	
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" and user_name like '%".$name."%'" : $wheresql.=" user_name like '%".$name."%'");
		
	//------ code for pagination ----------------
	if($_POST['search'] !='') 
	{
		$sql1 = "select * from admin_user_type where ".$wheresql." order by menu_order asc";
	}else{
		$sql1 = "select * from admin_user_type order by menu_order asc";
	}
	$rowsperpage =20;
	$website = "index.php?page=admin_user_type_list";
	$pagination = new Pagination($sql1, $rowsperpage, $website, $dbconnect);
	$pagination->setPage($_GET['page1']);
	$pageList =$pagination->showPage();
		
	
	if($name !='') 
	{
		$sql = "select * from admin_user_type where ".$wheresql." order by menu_order asc limit " . $pagination->getLimit() . ", " . $rowsperpage;
	} 
	else
	{
		$sql = "select * from admin_user_type order by menu_order asc limit " . $pagination->getLimit() . ", " . $rowsperpage;
	}
	// echo $sql;
	$qry = q($sql,$dbconnect);
	$cols=$lowerLimit+1;
	$test1=1;
	if(nr($qry) > 0 ) 
	{
		while ($result = f($qry))
		{	 
		
		if(!empty($result['postdate']))
		{
			 $postdate = date('d M Y',$result['postdate']);
		}  
		
		if($result['status']==1)
		{
			$active='<img src="images/tick.png" alt="Published" border="0">';
		}else
		{
			$active='<img src="images/publish_x.png" alt="Unpublished" border="0">';
		}
			
		if ($test1==1)
		 {
$text .= "<tr class='table_row1'>
<td align='center' height=22 class='top_lightblue_link'>$cols</td>
<td align='left' height=22><a href='index.php?page=admin_user_type_details&id=$result[id]' class='top_lightblue_link'>".$result[user_name]." </a></td>
<td align='center' height=22><input type='text' size='3' name='menuorder[]' value='$result[menu_order]'>
<input type='hidden' name='menuid[]' value='$result[id]' /></td>
<td align='center' height=22><a href='#' onClick='fnStatus(".$result[id].",".$result[status].")' class='top_lightblue_link'>$active </a> </td>
<td align='center' height=22><a href='index.php?page=admin_user_type_details&id=$result[id]' class='top_lightblue_link'><img src='images/edit.jpg' border='0' title='Edit This Record'> </a> </td>
<td align='center'><input name='checkList[]' type='checkbox' value='$result[id]'><input name='checkList[]' type='hidden' value='0'></td>
</tr>";
$test1=0;
		 }
		 else
		 {
$text .= "<tr class='table_row'><td class='top_lightblue_link' align='center' height=22>$cols</td>
<td align='left' height=22><a href='index.php?page=admin_user_type_details&id=$result[id]' class='top_lightblue_link'>".$result[user_name]." </a></td>
<td align='center' height=22><input type='text' size='3' name='menuorder[]' value='$result[menu_order]'>
<input type='hidden' name='menuid[]' value='$result[id]' /></td>
<td align='center' height=22><a href='#' onClick='fnStatus(".$result[id].",".$result[status].")' class='top_lightblue_link'>$active </a> </td>
<td align='center' height=22><a href='index.php?page=admin_user_type_details&id=$result[id]' class='top_lightblue_link'><img src='images/edit.jpg' border='0' title='Edit This Record'> </a> </td>
<td align='center'><input name='checkList[]' type='checkbox' value='$result[id]'><input name='checkList[]' type='hidden' value='0'></td></tr>";
$test1=1;
		 }	
		 $cols++;
		}
	} else {
		$text .= "<tr class='table_row'><td align='center' height=22 colspan='7'><font color='red'>No such a record found.</font></td></tr>";
	}
	include $htmlfile."admin_user_type_list.html";
?>
