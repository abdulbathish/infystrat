<?php
	if($access_page==0) { header("location:index.php"); die(); }

	$userid_chkid=$_POST['userid1'];
	$useract_ststus=$_POST['status1'];		

	if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] && $userid_chkid !="")
	{
		if($useract_ststus==1)
		$set_sts = 0;
		else
		$set_sts = 1; 
		
		q("update general_pages set status='$set_sts' where id='$userid_chkid'",$dbconnect);
	}     

	// update page order starts 
	if($_POST['updateOrder'] == "update")
	{
		$menuorder = $_POST['menuorder'];
		$menuid = $_POST['menuid'];
		$array_order = @array_combine($menuid,$menuorder);
		
		if(sizeof($array_order)>0)
		{
			foreach($array_order as $key => $value)
			{
				if($value)
				{
					
					$sql_update = "update general_pages set page_order=$value where id=$key";
					$qry = q($sql_update,$dbconnect);
				}
			}
		}		
	}
	// update page order starts	 Ends
	
	
	//--------- Pagination code -------//
	$sql1="select * from general_pages where parent_id=0 order by page_order ASC";
	$rowsperpage = 20;
	$website = "index.php?page=page_list";
	$pagination = new Pagination($sql1, $rowsperpage, $website, $dbconnect);
	$pagination->setPage($_GET['page1']);
	$pageList =$pagination->showPage();

	//------- End of pagination code --------//
	
	$name=$_POST['search'];
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" and page_title like '%".$name."%'" : $wheresql.=" page_title like '%".$name."%'");
	//$name=="" ? $name= "" : ($wheresql ? $wheresql.=" or subtitle like '%".$name."%'" : $wheresql.=" subtitle like '%".$name."%'");
	
	if($name !='') 
	{
		$sql = "select * from general_pages where parent_id=0 ".$wheresql." order by page_order ASC limit " . $pagination->getLimit() . ", " . $rowsperpage;
	} 
	else
	{
		$sql = "select * from general_pages where parent_id=0 order by page_order ASC limit " . $pagination->getLimit() . ", " . $rowsperpage;
	}
	
	//echo $sql;
	
	$qry = q($sql,$dbconnect);
	$start_limit=$pagination->getLimit();
	$cols= $start_limit+1;
	$test1=1;
	if(nr($qry) > 0 ) 
	{
		while ($result = f($qry))
		{		
			if($result['position']==1){
				$position= 'Top';
			} else if($result['position']==2){
				$position= 'Bottom';
			} else {
				$position= '-';
			}
			
			if($result['status']==1)
			 {
					$active="<img src='images/tick.png' title='Click here to dectivate' border=0>";
			 } 
			 else 
			 {
					$active="<img src='images/publish_x.png' title='Click here to activate' border=0>";
			 }			
			 
			$sel_subpage = "select * from general_pages where status=1 and parent_id='$result[id]'";
			$res_subpage = q($sel_subpage,$dbconnect);
			$cnt_subpage = nr($res_subpage);
			
		if ($test1==1)
		 { //<td align='center'><input name='checkList[]' type='checkbox' value='$result[id]'><input type='hidden' name='checkList[]' id='checkList[]' value='0'></td>
		 $text .= "<tr class='table_row1'>
		 <td align='center' height=22>$cols</td>
		 <td align='left' height=22>&nbsp;<a href='index.php?page=page_details&id=$result[id]' class='top_lightblue_link'>&nbsp;$result[page_title] </a></td>
		 <td align='left' height=22>&nbsp;<a href='index.php?page=page_details&id=$result[id]' class='top_lightblue_link'>&nbsp;$position </a></td>
		 <td align='center' height='22'><a href='index.php?page=subpage_list&pageid=$result[id]' class='top_lightblue_link'>($cnt_subpage) </a></td>
		 <td align='center' height=22><input type='text' size='3' name='menuorder[]' value='$result[page_order]'>
		 <input type='hidden' name='menuid[]' value='$result[id]' /></td> 
		 <td align='center' height=22 style='padding-left:15px;'><a href='#' onClick='fnStatus(".$result[id].",".$result[status].")' class='top_lightblue_link'>$active</a></td>
		 <td align='center' height=22>&nbsp;<a href='index.php?page=page_details&id=$result[id]' class='top_lightblue_link'>&nbsp;<img src='images/edit.jpg' border='0'></a></td>		 
		 </tr>";
		 
		 $test1=0;
		 }
		 else
		 { 
		 $text .= "<tr class='table_row'>
		 <td align='center' height=22>$cols</td>
		 <td align='left' height='22'>&nbsp;<a href='index.php?page=page_details&id=$result[id]' class='top_lightblue_link'>&nbsp;$result[page_title] </a></td>
		 <td align='left' height='22'>&nbsp;<a href='index.php?page=page_details&id=$result[id]' class='top_lightblue_link'>&nbsp;$position </a></td>
		 <td align='center' height='22'><a href='index.php?page=subpage_list&pageid=$result[id]' class='top_lightblue_link'>($cnt_subpage) </a></td>
		 <td align='center' height=22><input type='text' size='3' name='menuorder[]' value='$result[page_order]'>
		 <input type='hidden' name='menuid[]' value='$result[id]' /></td>
		 <td align='center' height=22 style='padding-left:15px;'><a href='#' onClick='fnStatus(".$result[id].",".$result[status].")' class='top_lightblue_link'>$active</a></td>
		 <td align='center' height=22>&nbsp;<a href='index.php?page=page_details&id=$result[id]' class='top_lightblue_link'>&nbsp;<img src='images/edit.jpg' border='0'></a></td>		
		 </tr>";
		
		 $test1=1;
		 }	
		 $cols++;
		}
	} else {
		$text .= "<tr class='table_row'><td align='center' height=22 colspan='6'><font color='red'>No such a record found.</font></td></tr>";
	}
	include $htmlfile."page_list.html";
?>
