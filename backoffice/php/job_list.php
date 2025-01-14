<?php
if($access_job==0) { header("location:index.php"); }
	$name=trim($_REQUEST['search']);
	$userid_chkid=$_POST['userid1'];
	$useract_ststus=$_POST['status1'];		

	if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] && $userid_chkid !="")
	{
		if($useract_ststus==1)
		$set_sts = 0;
		else
		$set_sts = 1; 
		
		q("update tbl_job set fld_status='$set_sts' where fld_id='$userid_chkid'",$dbconnect);
	}     	
	
	//------ update default ---//
	$default_id=$_GET['did'];
	if($default_id !='')
	{
	    if($_GET['default']==0){
		     $sql = "update tbl_job set fld_sethome='1' where fld_id=$default_id";
		     $sql1 = "update tbl_job set fld_sethome='0' where fld_id != $default_id ";
		}else{
			$sql1 = "update tbl_job set fld_sethome='0' where fld_id = $default_id ";
		}
		q($sql,$dbconnect);
		q($sql1,$dbconnect);
	}
	//-------- End of default update ----//
	
	//----- update menu order ---------
	if($_POST['updateOrder'] == "update")
	{
	
		$menuorder = $_POST['menuorder'];
		$menuid = $_POST['menuid'];
		$array_order = array_combine($menuid,$menuorder);
		foreach($array_order as $key => $value)
		{
			if($value)
			{
				
				$sql_update = "update tbl_job set fld_menuorder=$value where fld_id = $key";
				$qry = q($sql_update,$dbconnect);
			}
		}
	}
	
	
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" and fld_jobname like '%".$name."%'" : $wheresql.=" fld_jobname like '%".$name."%'");
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" or description like '%".$name."%'" : $wheresql.=" description like '%".$name."%'");
	
	//------ code for pagination ----------------
	if($_POST['search'] !='') 
	{
		$sql1 = "select * from tbl_job where ".$wheresql." order by fld_menuorder asc";
	}else{
		$sql1 = "select * from tbl_job order by fld_menuorder asc";
	}
	$rowsperpage = 20;
	$website = "index.php?page=gallery_list";
	$pagination = new Pagination($sql1, $rowsperpage, $website, $dbconnect);
	$pagination->setPage($_GET['page1']);
	$pageList =$pagination->showPage();
	
	
	if($name !='') 
	{
		$sql = "select * from tbl_job where ".$wheresql." order by fld_menuorder asc limit " . $pagination->getLimit() . ", " . $rowsperpage;
	} 
	else
	{
		$sql = "select * from tbl_job order by fld_menuorder asc limit " . $pagination->getLimit() . ", " . $rowsperpage;
	}
	// echo $sql;
	$qry = q($sql,$dbconnect);
	$cols=$lowerLimit+1;
	$test1=1;
	if(nr($qry) > 0 ) 
	{
		while ($result = f($qry))
		{	 
			
		if(!empty($result['fld_jobname']))
		{
		 	$jobname =$result['fld_jobname'];
		} else {
		    $jobname = " -- ";
		}
		if(!empty($result['fld_position']))
		{
		 	$position =$result['fld_position'];
		} else {
		    $position = " -- ";
		}
		if(!empty($result['fld_location']))
		{
		 	$location =$result['fld_location'];
		} else {
		    $location = " -- ";
		}
		
		if($result['fld_status']==1){
			$active='<img src="images/tick.png" alt="Published" border="0">';
		} else {
			$active='<img src="images/publish_x.png" alt="Unpublished" border="0">';
		}	
		
		if($result['fld_sethome']==1)
		{
			$default='<img src="images/tick.png" alt="Published" border="0">';
		} else
		{
			$default='<img src="images/publish_x.png" alt="Unpublished" border="0">';
		}
			
		$sel_jobs_count= "select * from tbl_job_apply where jobid=$result[fld_id]";
		$res_jobs_count = q($sel_jobs_count,$dbconnect);
		$count_apply= nr($res_jobs_count);
		   
		if ($test1==1)
		 {
			$text .= "<tr class='table_row1'>
			<td align='center' height=22 class='top_lightblue_link'>$cols</td>
			<td align='left' height=22><a href='index.php?page=job_details&id=$result[fld_id]' class='top_lightblue_link'>".utf8_decode($jobname)." </a></td>
			<td align='center' height=22><a href='index.php?page=job_details&id=$result[fld_id]' class='top_lightblue_link'>$position </a> </td>
			<td align='center' height=22><a href='index.php?page=job_details&id=$result[fld_id]' class='top_lightblue_link'>$location </a> </td>
			<!--<td align='center' height=22><a href='index.php?page=career_job_apply_list&job_id=$result[fld_id]' class='top_lightblue_link'>($count_apply) </a> </td>-->
			<td align='center' height=22><input type='text' size='3' name='menuorder[]' value='$result[fld_menuorder]'>
			<input type='hidden' name='menuid[]' value='$result[fld_id]' /></td>
			<td align='center' height=22><a href='#' onClick='fnStatus(".$result[fld_id].",".$result[fld_status].")' class='top_lightblue_link'>$active </a> </td>
			<td align='center' height=22><a href='index.php?page=job_details&id=$result[fld_id]' class='top_lightblue_link'><img src='images/edit.jpg' border='0' title='Edit This Record'> </a> </td>
			<td align='center'><input name='checkList[]' type='checkbox' value='$result[fld_id]'><input name='checkList[]' type='hidden' value='0'></td>
			</tr>";
			$test1=0;
		 }
		 else
		 {
			$text .= "<tr class='table_row'><td class='top_lightblue_link' align='center' height=22>$cols</td>
			<td align='left' height=22><a href='index.php?page=job_details&id=$result[fld_id]' class='top_lightblue_link'>".utf8_decode($jobname)." </a></td>
			<td align='center' height=22><a href='index.php?page=job_details&id=$result[fld_id]' class='top_lightblue_link'>$position </a> </td>
			<td align='center' height=22><a href='index.php?page=job_details&id=$result[fld_id]' class='top_lightblue_link'>$location </a> </td>
			<!--<td align='center' height=22><a href='index.php?page=career_job_apply_list&job_id=$result[fld_id]' class='top_lightblue_link'>($count_apply) </a> </td>-->
			<td align='center' height=22><input type='text' size='3' name='menuorder[]' value='$result[fld_menuorder]'>
			<input type='hidden' name='menuid[]' value='$result[fld_id]' /></td>
			<td align='center' height=22><a href='#' onClick='fnStatus(".$result[fld_id].",".$result[fld_status].")' class='top_lightblue_link'>$active </a> </td>
			<td align='center' height=22><a href='index.php?page=job_details&id=$result[fld_id]' class='top_lightblue_link'><img src='images/edit.jpg' border='0' title='Edit This Record'> </a> </td>
			<td align='center'><input name='checkList[]' type='checkbox' value='$result[fld_id]'><input name='checkList[]' type='hidden' value='0'></td></tr>";
			$test1=1;
		 }
		 $cols++;
		}
	} else {
		$text .= "<tr class='table_row'><td align='center' height=22 colspan='9'><font color='red'>No such a record found.</font></td></tr>";
	}
	include $htmlfile."job_list.html";
?>