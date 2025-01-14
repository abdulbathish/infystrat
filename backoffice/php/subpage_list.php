<?php
	if($access_page==0) { header("location:index.php"); die(); }
	if($_GET['page1']!=""){
		$pagination_no = $_GET['page1'];
	} else {
		$pagination_no = $_POST['page1'];
	}

	if($pagination_no!="")
	{
		$page_number="&page1=".$pagination_no;
	} else {
		$page_number="";
	}

	if(isset($_GET['perpage'])){
		$perpage= $_GET['perpage'];
	}

	if($_POST['pageid']!=''){
		$pageid = $_POST['pageid'];
	}else{
		$pageid = $_GET['pageid'];
	}

	$sel_page = "select * from general_pages where status=1 and id='$pageid'";
	$res_page = q($sel_page,$dbconnect);
	$row_page = f($res_page);
	$page_name = $row_page['page_title'];

	//------ update status ---//
	$banid=$_GET['id'];
	if($banid !='')
	{
	     if($_GET['app']==1){
		     $sql = "update general_pages set status='2' where id=$banid";
		}else{
		     $sql = "update general_pages set status='1' where id=$banid";
		}
	  	q($sql,$dbconnect);
	}
	//-------- End of status update ----//

	// update page order starts
	if($_POST['updateOrder'] == "Update")
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

	if($perpage!="" && $perpage!="all")
	{
		$rowsperpage = $perpage;
	} else {
		$rowsperpage = 50;
	}
	//--------- Pagination code -------//
	if($name !='')
	{
		$sql1 = "select * from general_pages where ".$wheresql." and parent_id=$pageid order by page_order ASC";
		$website = "index.php?page=subpage_list&search=".$search_name."&pageid=$pageid&perpage=".$rowsperpage;
	}else{
		$sql1 = "select * from general_pages where parent_id=$pageid order by page_order ASC ";
		$website = "index.php?page=subpage_list&pageid=$pageid&perpage=".$rowsperpage;
	}
	$pagination = new Pagination($sql1, $rowsperpage, $website, $dbconnect);
	$pagination->setPage($_GET['page1']);
	$pageList =$pagination->showPage();
	//------- End of pagination code --------//

	$name=$_POST['search'];
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" and page_title like '%".$name."%'" : $wheresql.=" page_title like '%".$name."%'");
	//$name=="" ? $name= "" : ($wheresql ? $wheresql.=" or subtitle like '%".$name."%'" : $wheresql.=" subtitle like '%".$name."%'");

	if($name !='')
	{
		$sql = "select * from general_pages where ".$wheresql." and parent_id=$pageid order by page_order ASC limit " . $pagination->getLimit() . ", " . $rowsperpage;
	}
	else
	{
		$sql = "select * from general_pages where parent_id=$pageid order by page_order ASC limit " . $pagination->getLimit() . ", " . $rowsperpage;
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
			$subtitle=substr($result['subtitle'],0,50);
			$total_hits = $result['hits'];
			if($result['status']==1)
			 {
				$active="<img src='images/tick.png' title='Click here to dectivate' border=0>";
			 }
			 else
			 {
				$active="<img src='images/publish_x.png' title='Click here to activate' border=0>";
			 }

			$last_mod = date("d-m-Y H:i:s",strtotime($result['fld_lastmodified']));

			$sel_modby = "select * from admin where status=1 and id='$login_userid'";
			$res_modby = q($sel_modby,$dbconnect);
			$row_modby = f($res_modby);

			$mod_by=$row_modby['full_name'];

		if ($test1==1)
		 {
		 $text .= "<tr class='table_row1'>
		 <td align='center' height=22>$cols</td>
		 <td align='left' height=22><a href='index.php?page=subpage_details&id=$result[id]&pageid=$pageid' class='top_lightblue_link'>$result[page_title] </a></td>
		 <td align='center' height=22><input type='text' size='3' name='menuorder[]' value='$result[page_order]'>
		 <input type='hidden' name='menuid[]' value='$result[id]' /></td>
		 <td align='center' height=22 style='padding-left:15px;'><a href='index.php?page=subpage_list&id=$result[id]&app=$result[status]&pageid=$pageid' class='top_lightblue_link'>$active</a></td>
		 <td align='center' height=22><a href='index.php?page=subpage_details&id=$result[id]&pageid=$pageid' class='top_lightblue_link'><img src='images/edit.jpg' border='0'></a></td>
		 <td align='center'><input name='checkList[]' type='checkbox' value='$result[id]'><input type='hidden' name='checkList[]' id='checkList[]' value='0'></td>
		 </tr>";
		 $test1=0;
		 }
		 else
		 {
		 $text .= "<tr class='table_row'>
		 <td align='center' height=22>$cols</td>
		 <td align='left' height='22'><a href='index.php?page=subpage_details&id=$result[id]&pageid=$pageid' class='top_lightblue_link'>$result[page_title] </a></td>
		 <td align='center' height=22><input type='text' size='3' name='menuorder[]' value='$result[page_order]'>
		 <input type='hidden' name='menuid[]' value='$result[id]' /></td>
		 <td align='center' height=22 style='padding-left:15px;'><a href='index.php?page=subpage_list&id=$result[id]&app=$result[status]&pageid=$pageid' class='top_lightblue_link'>$active</a></td>
		 <td align='center' height=22><a href='index.php?page=subpage_details&id=$result[id]&pageid=$pageid' class='top_lightblue_link'><img src='images/edit.jpg' border='0'></a></td>
		 <td align='center'><input name='checkList[]' type='checkbox' value='$result[id]'><input type='hidden' name='checkList[]' id='checkList[]' value='0'></td>
		 </tr>";

		 $test1=1;
		 }
		 $cols++;
		}
	} else {
		$text .= "<tr class='table_row'><td align='center' height=22 colspan='9'><font color='red'>No such a record found.</font></td></tr>";
	}
	include $htmlfile."subpage_list.html";
?>