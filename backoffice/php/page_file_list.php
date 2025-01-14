<?php
	if(isset($_POST["btn_submit"])!="")
	{
		$id= $_POST['id'];
		$page_id = $_POST['page_id'];		
		$file_name_up = str_replace("'","&rsquo;",$_POST['file_name']);	
		$para1 = str_replace("'","&rsquo;",$_POST['parameter1']);		
		
		$sql = "update tbl_page_file set page_id='$page_id', page_file_name='$file_name_up', parameter1='$para1' where id='$id'";
		
		if(q($sql,$dbconnect))
		{
			$page_file_details=f(q("select page_file_name from tbl_page_file where id=$id",$dbconnect));
			$page_details1=f(q("select page_title, url_title from general_pages where id=$page_id",$dbconnect));
			
			$file='../.htaccess';
			$phurl_name = replace_url($page_details1['page_title']);
			$url_title = replace_url($page_details1['url_title']);	
			
			if($url_title!="")
			{
				$url_str=$url_title;
			}else{
				$url_str=$phurl_name;
			}
			
			if($page_file_details['page_file_name']=="")
			{
				$file_name=$phurl_name.".php";
			}else
			{
				$file_name=$page_file_details['page_file_name'];
			}
			//$file_name=$phurl_name.".php";
			
			$parameter="pageid";
															
			$search="RewriteRule ^".$url_str."$ ".$file_name."?".$parameter."=".base64_encode($page_id)." [L]";
			$fh = fopen($file, 'r');
			$olddata = fread($fh, filesize($file));
			
			if(strpos($olddata, $search)) {
				$newdata = str_replace($search,"",$olddata);
				file_put_contents($file, $newdata);
			}
			else{
				//echo "Not Found";
			}
			//die();
			fclose($fh);
			
			$file='../.htaccess';
			
			$page_file_details=f(q("select page_file_name from tbl_page_file where id=$id",$dbconnect));
			$page_details1=f(q("select page_title, url_title from general_pages where id=$page_id",$dbconnect));
			
			$hurl_name=replace_url($page_details1['page_title']);
			
			$url_title=replace_url($page_details1['url_title']);	
			
			if($url_title!="")
			{
				$url_str=$url_title;
			}else{
				$url_str=$hurl_name;
			}
			
			if($page_file_details['page_file_name']=="")
			{
				$file_name=$hurl_name.".php";
			}else
			{
				$file_name=$page_file_details['page_file_name'];
			}
			
			if($para1!="")
			{
				$parameter=$para1;
			}else{
				$parameter="pageid";
			}
			
			$file_name=$page_file_details['page_file_name'];
			
			$rule="\n".'RewriteRule ^'.$url_str.'$ '.$file_name.'?'.$parameter.'='.base64_encode($page_id).' [L]'."\n";
			
			$fh = fopen($file, 'r');
			file_put_contents($file, $rule, FILE_APPEND | LOCK_EX);
			fclose($fh);
			
			$msg = "File Name updated successfully.";
	
		?>
			<script language="JavaScript">
				window.location="index.php?page=page_file_list&id=<?php echo $id;?>&msg=<?php echo $msg?>";
			</script>
		<?php
		}else{
		?>  
			<script language="JavaScript">
				window.location="index.php?page=page_file_list&id=<?php echo $id;?>&msg_error=File Name added Failed.";
			</script>
		<?php
		}
	}//if(isset($_POST["btn_submit"])!="")
		
	//--- select Download Category ---
	if(isset($_GET['id']) && $_GET['id']!="")
	{
		$id = $_GET[id];
	}
	$sql_page = "select * from tbl_page_file where id = $id";
	$qry_page = q($sql_page,$dbconnect);
	$page_new = f($qry_page);
	//print_r($page_new);
	if($id!=""){
		$button_name = "Update";
	}else{
		$button_name = "Add";
	}
	$page_id = $page_new['page_id'];
	$page_file_name = $page_new['page_file_name'];
	$parameter1 = $page_new['parameter1'];
	
	$sql1 = "select * from tbl_page_file order by page_id asc";
	
	$rowsperpage =20;
	$website = "index.php?page=page_file_list";
	$pagination = new Pagination($sql1, $rowsperpage, $website, $dbconnect);
	$pagination->setPage($_GET['page1']);
	$pageList =$pagination->showPage();
	
	$sql_list = "select * from tbl_page_file order by page_id asc limit " . $pagination->getLimit() . ", " . $rowsperpage;
	$qry_list = q($sql_list,$dbconnect);
	/*$cols= $lowerLimit+1;*/
	$start_limit=$pagination->getLimit();
	$cols= $start_limit+1;
	$test1=1;
	if(nr($qry_list) > 0 ) 
	{
		while ($result_list = f($qry_list))
		{
			$page_details=f(q("select page_title from general_pages where id=$result_list[page_id]",$dbconnect));
			$page_title=$page_details['page_title'];	
			$file_name=$result_list['page_file_name'];
			$parameter=$result_list['parameter1'];
			$parameter2=$result_list['parameter2'];
					
			$text .= "<tr class='table_row1'>
				<td align='center' height=22>$cols</td>	
				<td align='left' height=22><a href='index.php?page=page_file_list&id=$result_list[id]' class='top_lightblue_link'>&nbsp;&nbsp;".$page_title."</a></td>
				<td align='left' height=22><a href='index.php?page=page_file_list&id=$result_list[id]' class='top_lightblue_link'>&nbsp;&nbsp;".$file_name."</a></td>
				<td align='left' height=22><a href='index.php?page=page_file_list&id=$result_list[id]' class='top_lightblue_link'>&nbsp;&nbsp;".$parameter."</a></td>
				<td align='left' height=22><a href='index.php?page=page_file_list&id=$result_list[id]' class='top_lightblue_link'>&nbsp;&nbsp;".$parameter2."</a></td>
				
			</tr>";		  
			$cols++;
		}
	} 
	else {
		$text .= "<tr class='table_row'><td align='center' height=22 colspan='7'><font color='red'>No such a record found.</font></td></tr>";
	}
	include $htmlfile."page_file_list.html";
?>	