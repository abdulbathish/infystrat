<?php
	$name=trim($_REQUEST['search']);	
	
	//------ To set home  page thumb update statue ------//
	$banid=$_GET['id'];
	if($banid !='')
	{
	    if($_GET[app]==1)
		{
		     $sql = "update tbl_download set fld_status='0' where fld_id=$banid"; 
		}else{
		       $sql = "update tbl_download set fld_status='1' where fld_id=$banid"; 
		}	   
	  	  q($sql,$dbconnect);
	}
	//-------- End of tbl_download status update ----//
	
	//-------- update menu order ------------------------//
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
					$sql_update = "update tbl_download set fld_menuorder=$value where fld_id = $key";
					$qry = q($sql_update,$dbconnect);
				}
			}
		}
	}
	
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" and fld_title like '%".$name."%'" : $wheresql.=" fld_title like '%".$name."%'");
	
	
	//------ code for pagination ----------------
	if($_POST['search'] !='') 
	{
		$sql1 = "select * from tbl_download where ".$wheresql." order by fld_menuorder ASC";
	}else{
		$sql1 = "select * from tbl_download order by fld_menuorder ASC";
	}
	//echo $sql1;
	$rowsperpage =20;
	$website = "index.php?page=download_list";
	$pagination = new Pagination($sql1, $rowsperpage, $website, $dbconnect);
	$pagination->setPage($_GET['page1']);
	$pageList =$pagination->showPage();
	
	if($name !='') 
	{
		$sql = "select * from tbl_download where ".$wheresql." order by fld_menuorder ASC limit " . $pagination->getLimit() . ", " . $rowsperpage;
	} 
	else
	{
		$sql = "select * from tbl_download order by fld_menuorder ASC limit " . $pagination->getLimit() . ", " . $rowsperpage;
	}
	// echo $sql;
	$qry = q($sql,$dbconnect);
	$cols=$lowerLimit+1;
	$test1=1;
	if(nr($qry) > 0 ) 
	{
		while ($result = f($qry))
		{	 		
			if(!empty($result['fld_title']))
			{
				$title =$result['fld_title'];
			} 
			else
				$title = "-";	

			if(!empty($result['fld_url']))
			{
				 $url = $result['fld_url'];
			}  
				
		if($result['fld_status']==1){
			$active='<img src="images/tick.png" alt="Published" border="0">';
		} else {
			$active='<img src="images/publish_x.png" alt="Unpublished" border="0">';
		}
		   
		if ($test1==1)
		 {
$text .= "<tr class='table_row1'>
<td align='center' height=22 class='top_lightblue_link'>$cols</td>
<td align='left' height=22><a href='index.php?page=download_details&id=$result[fld_id]' class='top_lightblue_link'>".$title." </a></td>
<td align='center' height=22><input type='text' size='3' name='menuorder[]' value='$result[fld_menuorder]'>
<input type='hidden' name='menuid[]' value='$result[fld_id]' /></td>
<td align='center' height=22><a href='index.php?page=download_list&id=$result[fld_id]&app=$result[fld_status]' class='top_lightblue_link'>$active </a> </td>
<td align='center' height=22><a href='index.php?page=download_details&id=$result[fld_id]' class='top_lightblue_link'><img src='images/edit.jpg' border='0' title='Edit This Record'> </a> </td>
<td align='center'><input name='checkList[]' type='checkbox' value='$result[fld_id]'><input name='checkList[]' type='hidden' value='0'></td>
</tr>";
$test1=0;
		 }
		 else
		 {
$text .= "<tr class='table_row'><td class='top_lightblue_link' align='center' height=22>$cols</td>
<td align='left' height=22><a href='index.php?page=download_details&id=$result[fld_id]' class='top_lightblue_link'>".$title." </a></td>
<td align='center' height=22><input type='text' size='3' name='menuorder[]' value='$result[fld_menuorder]'>
<input type='hidden' name='menuid[]' value='$result[fld_id]' /></td>
<td align='center' height=22><a href='index.php?page=download_list&id=$result[fld_id]&app=$result[fld_status]' class='top_lightblue_link'>$active </a> </td>
<td align='center' height=22><a href='index.php?page=download_details&id=$result[fld_id]' class='top_lightblue_link'><img src='images/edit.jpg' border='0' title='Edit This Record'> </a> </td>
<td align='center'><input name='checkList[]' type='checkbox' value='$result[fld_id]'><input name='checkList[]' type='hidden' value='0'></td></tr>";
$test1=1;
		 }	
		 $cols++;
		}
	} else {
		$text .= "<tr class='table_row'><td align='center' height=22 colspan='7'><font color='red'>No such a record found.</font></td></tr>";
	}
	include $htmlfile."download_list.html";
?>
