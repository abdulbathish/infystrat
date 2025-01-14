<?php
if($access_adminuser==0) { header("location:index.php"); die(); }

	//----- update menu order ---------
	if($_POST['updateOrder'] == "Update")
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
					$sql_update = "update user_authentication set menu_order=$value where id = $key";
					$qry = q($sql_update,$dbconnect);
				}
			}
	    }
	}
	//----- End of update menu order ---------
	
	//------ update status ---//
	$banid=$_GET['id'];
	if($banid !='')
	{
	     if($_GET[app]==1){
		     $sql = "update user_authentication set status='0' where id=$banid"; 
		}else{
		       $sql = "update user_authentication set status='1' where id=$banid"; 
		}	   
	  	  q($sql,$dbconnect);
	}
	//-------- End of status update ----//
	
	if(isset($_POST["btn_submit"])!="")
	{
		$id= $_POST['id'];
		$typename = str_replace("'","&rsquo;",$_POST['txttypename']);		
		$paravalue = str_replace("'","&rsquo;",$_POST['paravalue']);		
		
		if($id == 0) 
		{		  
			$sql = "insert into user_authentication(id,name,paravalue,status) values('','$typename','$paravalue','1')";
		}else{
			$sql = "update user_authentication set name='$typename', paravalue='$paravalue', status='$active' where id='$id'";
		}
		if(q($sql,$dbconnect))
		{
			if($id=="" || $id==0)
			{
				$msg = "User Authentication added successfully.";
			}else{
				$msg = "User Authentication updated successfully.";
			}
		?>
			<script language="JavaScript">
			window.location="index.php?page=user_authentication_list&id=<?php echo $id;?>&msg=<?php echo $msg?>";
			</script>
		<?php
		}else{
		?>  
			<script language="JavaScript">
			window.location="index.php?page=user_authentication_list&id=<?php echo $id;?>&msg_error=User authentication added Failed.";
			</script>
		<?php
		}
	}//if(isset($_POST["btn_submit"])!="")
	
	
	
	//--- select Download Category ---
	$id = $_GET[id];
	$sql = "select * from user_authentication where id = $id";
	$qry = q($sql,$dbconnect);
	$result_list = f($qry);
	if($id!=""){
		$button_name = "Update";
	}else{
		$button_name = "Add";
	}
	$typename = $result_list['name'];
	$paravalue = $result_list['paravalue'];
	
	$name=trim($_POST[search]);
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" and name like '%".$name."%'" : $wheresql.=" name like '%".$name."%'");
			
	//------ code for pagination ----------------
	if($_POST['search'] !='') 
	{
		$sql1 = "select * from user_authentication where ".$wheresql." order by menu_order asc";
	} else {
		$sql1 = "select * from user_authentication order by menu_order asc";
	}
	$rowsperpage =20;
	$website = "index.php?page=user_authentication_list";
	$pagination = new Pagination($sql1, $rowsperpage, $website, $dbconnect);
	$pagination->setPage($_GET['page1']);
	$pageList =$pagination->showPage();
	
	if($name !='') 
	{
		$sql_list ="select * from user_authentication where ".$wheresql." order by menu_order asc limit " . $pagination->getLimit() . ", " . $rowsperpage;
	} 
	else
	{
		$sql_list = "select * from user_authentication order by menu_order asc limit " . $pagination->getLimit() . ", " . $rowsperpage;
	}
	$qry_list = q($sql_list,$dbconnect);
	/*$cols= $lowerLimit+1;*/
	$start_limit=$pagination->getLimit();
	$cols= $start_limit+1;
	$test1=1;
	if(nr($qry_list) > 0 ) 
	{
		while ($result_list = f($qry_list))
		{
			if(!empty($result_list['name']))
			{				
				$mtypename =$result_list['name'];				
			}
			else
				$mtypename = " -- ";

			if(!empty($result_list['paravalue']))
			{				
				$paravalue_db =$result_list['paravalue'];				
			}
			else
				$paravalue_db = " -- ";
		
			if($result_list['status']==1)
			{
				$active='<img src="images/tick.png" alt="Published" border="0">';
			} else
			{
				$active='<img src="images/publish_x.png" alt="Unpublished" border="0">';
			}
						
		$text .= "<tr class='table_row1'>
		<td align='center' height=22>$cols</td>	
		<td align='left' height=22><a href='index.php?page=user_authentication_list&id=$result_list[id]' class='top_lightblue_link'>".$mtypename."</a></td>
		<td align='left' height=22><a href='index.php?page=user_authentication_list&id=$result_list[id]' class='top_lightblue_link'>".$paravalue_db."</a></td>
		<td align='center' height=22>
		<input type='text' size='3' name='menuorder[]' value='$result_list[menu_order]' class='boldtext'>
		<input type='hidden' name='menuid[]' value='$result_list[id]' /></td>
		<td align='center' height=22><a href='index.php?page=user_authentication_list&id=$result_list[id]&app=$result_list[status]' class='top_lightblue_link'>$active </a> </td>
		<td align='center' height=22><a href='index.php?page=user_authentication_list&id=$result_list[id]' class='top_lightblue_link'><img src='images/edit.jpg' border='0' title='Edit This Record'> </a> </td>	
		<td align='center'><input name='checkList[]' type='checkbox' value='$result_list[id]'><input type='hidden' name='checkList[]' id='checkList[]' value='0'></td>
		</tr>";		  
		 $cols++;
		}
	} else {
		$text .= "<tr class='table_row'><td align='center' height=22 colspan='7'><font color='red'>No such a record found.</font></td></tr>";
	}
	include $htmlfile."user_authentication_list.html";
?>	