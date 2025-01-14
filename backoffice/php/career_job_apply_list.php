<?php
	ob_start();
	global $menuorder,$menuid,$array_order,$value,$key,$sql_update,$qry,$status,$activeval,$id,$status,$sql,$name,$cols,$test1,$result,$active,$activeval,$image,$cols;
	//--- display providers by subcategory -----
	
	
	$jobid = $_GET['job_id'];	
	//echo ">>>". $jobid;
	
	$name=$_POST["search"];
	
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" and applier_name  like '%".$name."%'" : $wheresql.=" applier_name like '%".$name."%'");
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" or email  like '%".$name."%'" : $wheresql.=" email like '%".$name."%'");
	
	/*//------ code for pagination ----------------
	if($_POST['search'] !='') 
	{
		$sql1 = "select * from career_job_apply where ".$wheresql." order by id desc";
	}else{
		$sql1 = "select * from career_job_apply where 1 order by id desc";
	}
	//echo $sql1;*/
	
	if($jobid!='')
	{
		$sql1 = "select * from tbl_job_apply  where jobid=$jobid order by id desc";
	}else
	{
		$sql1 = "select * from tbl_job_apply  order by id desc";
	}
	
	
	$rowsperpage = 20;
	$website = "index.php?page=tbl_job_apply _list&job_id=".$jobid;
	$pagination = new Pagination($sql1, $rowsperpage, $website, $dbconnect);
	$pagination->setPage($_GET['page1']);
	$pageList =$pagination->showPage();
	
	if($name !='') 
	{
	  if($jobid!=''){
	  $sql = "select * from tbl_job_apply  where jobid=$jobid AND ".$wheresql." order by id desc limit " . $pagination->getLimit() . ", " . $rowsperpage;
	  } else{
			$sql = "select * from tbl_job_apply  where ".$wheresql." order by id desc limit " . $pagination->getLimit() . ", " . $rowsperpage;
		} 		
	} 
	else
	{
		if($jobid!='')
		{
			$sql = "select * from tbl_job_apply  where jobid=$jobid order by id desc limit " . $pagination->getLimit() . ", " . $rowsperpage;
		}else
		{
			$sql = "select * from tbl_job_apply  order by id desc limit " . $pagination->getLimit() . ", " . $rowsperpage;
		}
	}	
	//echo "<br>sql : ".$sql;
	
	$qry = q($sql,$dbconnect);
	$cols=1;
	$test1=1;
	
	if(nr($qry) > 0 ) 
	{
		while ($result = f($qry))
		{		
			//------ display job name ----
			$sel_job = "select fld_jobname from tbl_job where fld_id='$result[jobid]'";
			$res_job = q($sel_job,$dbconnect);
			$row_job = f($res_job);
			$job_name = $row_job['fld_jobname'];
			
		 if ($test1==1)
		 {
		 $text .= "<tr class='table_row'><td align='center' height='22'>$cols</td>
		 <td align='left' height='22'><a href='index.php?page=career_job_apply_details&id=".$result['id']."&job_id=$jobid' class='top_lightblue_link'>".$job_name." </a></td>
		 <td align='left' height='22'><a href='index.php?page=career_job_apply_details&id=".$result['id']."&job_id=$jobid' class='top_lightblue_link'>".$result[applier_name]." </a></td>
		 <td align='left' height='22'><a href='index.php?page=career_job_apply_details&id=".$result['id']."&job_id=$jobid' class='top_lightblue_link'>".$result[email]." </a></td>
         <td align='center' height=22><a href='index.php?page=career_job_apply_details&id=$result[id]' class='top_lightblue_link'><a href='javascript:void(0)' onClick='show_mail($result[id])'> Reply </a></td>
		 <td align='center'><input name='checkList[]' type='checkbox' value='".$result['id']."'><input name='checkList[]' type='hidden' value='0'></td>
		 </tr>";
		 $test1=0;
		 }
		 else
		 {
		 $text .= "<tr class='table_row'><td align='center' height='22'>$cols</td>
		<td align='left' height='22'><a href='index.php?page=career_job_apply_details&id=".$result['id']."&job_id=$jobid' class='top_lightblue_link'>".$job_name." </a></td>
		<td align='left' height='22'><a href='index.php?page=career_job_apply_details&id=".$result['id']."&job_id=$jobid' class='top_lightblue_link'>".$result[applier_name]."</a></td>
		<td align='left' height='22'><a href='index.php?page=career_job_apply_details&id=".$result['id']."&job_id=$jobid' class='top_lightblue_link'>".$result[email]." </a></td>
        <td align='center' height=22><a href='index.php?page=career_job_apply_details&id=$result[id]' class='top_lightblue_link'><a href='javascript:void(0)' onClick='show_mail($result[id])'> Reply </a></td>
		 <td align='center'><input name='checkList[]' type='checkbox' value='".$result[id]."'><input name='checkList[]' type='hidden' value='0'></td>
		 </tr>";
		 $test1=1;
		 }	
		 $cols++;
		}
	} else {
		$text .= "<tr class='table_row'><td align='center' height='22' colspan='8'><font color='red'>No such a record found.</font></td></tr>";
	}
	
	include $htmlfile."career_job_apply_list.html";
?>
