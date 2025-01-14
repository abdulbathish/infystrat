<?php
if($access_contact==0) { header("location:index.php"); }
	$did=$_GET['did'];

	if($did !="")
	{
	  $count=count(split(",",$did))-1;
	  $split=split(",",$did);
	  for($i=0;$i<=$count;$i++){
		  $userid=$split[$i];
		  if($userid!='undefined'){
		  $sql = "delete from contactus where cid='$userid'";
		  q($sql,$dbconnect);
		  }		  
		}	
		?>
		  <script language="JavaScript">
			window.location="index.php?page=contactus&msg=Contactus deleted successfully";
		 </script>	
		  <?
	}
 
	
	$name=$_POST[search];
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" and fname like '%".$name."%'" : $wheresql.=" fname like '%".$name."%'");
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" or lname like '%".$name."%'" : $wheresql.=" lname like '%".$name."%'");
	$name=="" ? $name= "" : ($wheresql ? $wheresql.=" or email like '%".$name."%'" : $wheresql.=" email like '%".$name."%'");
	
	//----- Code for pagination ------
	if($_POST['search'] !='') 
	{
		$sql1 = "select * from contactus where ".$wheresql." order by cid desc";
	}else{
		$sql1 = "select * from contactus order by cid desc";
	}
	
	
	$rowsperpage = 20;
	$website = "index.php?page=contactus";
	$pagination = new Pagination($sql1, $rowsperpage, $website, $dbconnect);
	$pagination->setPage($_GET['page1']);
	$pageList =$pagination->showPage();
		
	if($name !='') 
	{
		$sql = "select * from contactus where ".$wheresql." order by cid desc limit " . $pagination->getLimit() . ", " . $rowsperpage;
	} 
	else
	{
		$sql = "select * from contactus order by cid desc limit " . $pagination->getLimit() . ", " . $rowsperpage;
	}
	
	$qry = q($sql,$dbconnect);
	$start_limit=$pagination->getLimit();
	$cols= $start_limit+1;
	$test1=1;
	if(nr($qry) > 0 ) 
	{
		while ($result = f($qry))
		{
			 
		 //$username= ucfirst($result['fname'])." ".ucfirst($result['lname']);
		 $username= ucfirst($result['fname']);
		 $email = $result['email'];
		 $tel_no = $result['telno'];
		 
		 if($result['contact_date']!="0000-00-00 00:00:00")
		 {
			$contact_us = date("d-m-Y - h:i:s A", strtotime($result['contact_date']));
		 }else{
		 	$contact_us = " -- ";
		 }	
	 
		if ($test1==1)
		 {
		 $text .= "<tr class='table_row1'>
				<td align='center' height=22>$cols</td>
				<td align='left' height=22><a href='index.php?page=contactus_details&cid=$result[cid]' class='top_lightblue_link'>$username </a></td>
				<td align='left'><a href='index.php?page=contactus_details&cid=$result[cid]' class='top_lightblue_link'>$result[email]</a></td> 
				<td align='center' height=22><a href='index.php?page=contactus_details&cid=$result[cid]' class='top_lightblue_link'>$contact_us</a></td>
				<td align='center' height=22><a href='index.php?page=contactus_details&cid=$result[cid]' class='top_lightblue_link'><a href='javascript:void(0)' onClick='show_mail($result[cid])'> Reply </a></td>
				<td align='center'><input name='checkList[]' type='checkbox' value='$result[cid]'><input name='checkList[]' type='hidden' value='0'></td>
		</tr>";
		 $test1=0;
		 }
		 else
		 {
		$text .= "<tr class='table_row'>
				<td align='center' height=22>$cols</td>
				<td align='left' height=22><a href='index.php?page=contactus_details&cid=$result[cid]' class='top_lightblue_link'>$username </a></td>
				<td align='left'><a href='index.php?page=contactus_details&cid=$result[cid]' class='top_lightblue_link'>$result[email]</a></td> 
				<td align='center' height=22><a href='index.php?page=contactus_details&cid=$result[cid]' class='top_lightblue_link'>$contact_us</a></td>
				<td align='center' height=22><a href='index.php?page=contactus_details&cid=$result[cid]' class='top_lightblue_link'><a href='javascript:void(0)' onClick='show_mail($result[cid])'> Reply </a></td>
				<td align='center'><input name='checkList[]' type='checkbox' value='$result[cid]'><input name='checkList[]' type='hidden' value='0'></td></tr>";
		 $test1=1;
		 }	
		 $cols++;	
		}
	} else {
		$text .= "<tr class='table_row'><td align='center' height=22 colspan='8'><font color='red'>No Record Found.</font></td></tr>";
	}
	include $htmlfile."contactus.html";
?>
