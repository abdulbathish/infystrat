<?php
	if(isset($_POST["btn_submit"])!="")
	{
		$id= $_POST['id'];
		
		$previous_other_file=f(q("select * from tbl_other_files where id=$id",$dbconnect));
		
		$page_id = $_POST['page_id'];	
		//$page_details1=f(q("select page_title, url_title from general_pages where id=$page_id",$dbconnect));
		//if($)	
		$prefix = str_replace(" ","&rsquo;",$_POST['prefix']);	
		$file_name_up = str_replace("'","&rsquo;",$_POST['file_name']);	
		$para1 = str_replace("'","&rsquo;",$_POST['parameter1']);	
		$para2 = str_replace("'","&rsquo;",$_POST['parameter2']);	
		$para3 = str_replace("'","&rsquo;",$_POST['parameter3']);	
		$para4 = str_replace("'","&rsquo;",$_POST['parameter4']);	
			
		if($id=="")
		{
			$sql = "INSERT INTO `tbl_other_files` (`id` ,`page_id` ,`prefix` ,`page_file_name` ,`parameter1` ,`parameter2` ,`parameter3` ,`parameter4` ,`parameter5`)VALUES ('NULL', '$page_id', '$prefix','$file_name_up', '$para1', '$para2', '$para3', '$para4', '$para5')";
		}else{
			$sql = "update tbl_other_files set page_id='$page_id', prefix='$prefix', page_file_name='$file_name_up', parameter1='$para1', parameter2='$para2', parameter3='$para3', parameter4='$para4' where id='$id'";
		}
		
		if(q($sql,$dbconnect))
		{
			if($id==""){
				$inserted_id=mysql_insert_id();
			
				$file='../.htaccess';
				$page_details1=f(q("select page_title, url_title from general_pages where id=$page_id",$dbconnect));
				
				$hurl_name=replace_url($page_details1['page_title']);
				$hurl_title=replace_url($page_details1['url_title']);
												
				/*if($hurl_title!="")
				{
					$url_prefix=$hurl_title;
				}else{
					$url_prefix=$hurl_name;
				}*/
				
				$url_prefix=$prefix;
				
				$file_name=$file_name_up;
				
				if($para1!="")
				{
					$param1="$para1=".base64_encode($page_id);
				}else
				{
					$param1="pageid=".base64_encode($page_id);
				}
				
				if($para2!="")
				{
					$suburl="/([a-zA-Z0-9_-]+)";
					$param2="$para2=".'$1';
				}else{
					$suburl="";
					$param2="";
				}
				if($para3!="")
				{
					$suburl2="/([a-zA-Z0-9_-]+)";
					$param3="&$para3=".'$2';
				}else{
					$suburl2="";
					$param3="";
				}
				
				if($para4!="")
				{
					$suburl3="/([a-zA-Z0-9_-]+)";
					$param4="&$para4=".'$3';
				}else{
					$suburl3="";
					$param4="";
				}
										
				$rule="\n".'RewriteRule ^'.$url_prefix.$suburl.$suburl2.$suburl3.'$ '.$file_name.'?'.$param1.'&'.$param2.$param3.$param4.' [L]'."\n";
				file_put_contents($file, $rule, FILE_APPEND | LOCK_EX);
			}else
			{
				$inserted_id=$id;
				$page_details1=f(q("select page_title, url_title from general_pages where id=$page_id",$dbconnect));
				
				$file='../.htaccess';
				$phurl_name = replace_url($page_details1['page_title']);
				$hurl_title = replace_url($page_details1['url_title']);	
				
				/*if($hurl_title!="")
				{
					$url_prefix=$hurl_title;
				}else{
					$url_prefix=$phurl_name;
				}*/
				$url_prefix=$previous_other_file['prefix'];
				
				$file_name=$previous_other_file['page_file_name'];
				
				$ppara1=$previous_other_file['parameter1'];
				$ppara2=$previous_other_file['parameter2'];
				$ppara3=$previous_other_file['parameter3'];
				$ppara4=$previous_other_file['parameter4'];
				$ppara5=$previous_other_file['parameter5'];
				
				if($ppara1!="")
				{
					$pparam1="$para1=".base64_encode($page_id);
				}else
				{
					$pparam1="pageid=".base64_encode($page_id);
				}
				
				if($ppara2!="")
				{
					$suburl="/([a-zA-Z0-9_-]+)";
					$pparam2="$para2=".'$1';
				}else{
					$suburl="";
					$pparam2="";
				}
				if($ppara3!="")
				{
					$suburl2="/([a-zA-Z0-9_-]+)";
					$pparam3="&$para3=".'$2';
				}else{
					$suburl2="";
					$pparam3="";
				}
				
				if($ppara4!="")
				{
					$suburl3="/([a-zA-Z0-9_-]+)";
					$pparam4="&$para4=".'$3';
				}else{
					$suburl3="";
					$pparam4="";
				}
										
				$search='RewriteRule ^'.$url_prefix.$suburl.$suburl2.$suburl3.'$ '.$file_name.'?'.$pparam1.'&'.$pparam2.$pparam3.$pparam4.' [L]';						
				//$search="RewriteRule ^".$url_str."$ ".$file_name."?".$parameter."=".base64_encode($page_id)." [L]";
				//$search='RewriteRule ^'.$url_prefix.$suburl.$suburl2.$suburl3.'$ '.$file_name.'?'.$param1.'&'.$param2.$param3.$param4.' [L]';
				
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
				$page_details1=f(q("select page_title, url_title from general_pages where id=$page_id",$dbconnect));
				
				$hurl_name=replace_url($page_details1['page_title']);
				$hurl_title=replace_url($page_details1['url_title']);
												
				/*if($hurl_title!="")
				{
					$url_prefix=$hurl_title;
				}else{
					$url_prefix=$hurl_name;
				}*/
				$url_prefix=$prefix;
				
				$file_name=$file_name_up;
				
				if($para1!="")
				{
					$param1="$para1=".base64_encode($page_id);
				}else
				{
					$param1="pageid=".base64_encode($page_id);
				}
				
				if($para2!="")
				{
					$suburl="/([a-zA-Z0-9_-]+)";
					$param2="$para2=".'$1';
				}else{
					$suburl="";
					$param2="";
				}
				if($para3!="")
				{
					$suburl2="/([a-zA-Z0-9_-]+)";
					$param3="&$para3=".'$2';
				}else{
					$suburl2="";
					$param3="";
				}
				
				if($para4!="")
				{
					$suburl3="/([a-zA-Z0-9_-]+)";
					$param4="&$para4=".'$3';
				}else{
					$suburl3="";
					$param4="";
				}
				
				$fh = fopen($file, 'r');					
				$rule="\n".'RewriteRule ^'.$url_prefix.$suburl.$suburl2.$suburl3.'$ '.$file_name.'?'.$param1.'&'.$param2.$param3.$param4.' [L]'."\n";
				file_put_contents($file, $rule, FILE_APPEND | LOCK_EX);
				fclose($fh);
			}
			
			
			$msg = "File Name updated successfully.";
	
		?>
			<script language="JavaScript">
				window.location="index.php?page=other_file_list&id=<?php echo $id;?>&msg=<?php echo $msg?>";
			</script>
		<?php
		}else{
		?>  
			<script language="JavaScript">
				window.location="index.php?page=other_file_list&id=<?php echo $id;?>&msg_error=File Name added Failed.";
			</script>
		<?php
		}
	}//if(isset($_POST["btn_submit"])!="")
		
	//--- select Download Category ---
	if(isset($_GET['id']) && $_GET['id']!="")
	{
		$id = $_GET[id];
	}
    $sql_page = "select * from tbl_other_files where id = $id";
	$qry_page = q($sql_page,$dbconnect);
	$page_new = f($qry_page);
	//print_r($page_new);
	if($id!=""){
		$button_name = "Update";
	}else{
		$button_name = "Add";
	}
	$page_id = $page_new['page_id'];
	$prefix = $page_new['prefix'];
	$page_file_name = $page_new['page_file_name'];
	$parameter1 = $page_new['parameter1'];
	$parameter2 = $page_new['parameter2'];
	$parameter3 = $page_new['parameter3'];
	$parameter4 = $page_new['parameter4'];
	
	$sql1 = "select * from tbl_other_files order by page_id asc";
	
	$rowsperpage =20;
	$website = "index.php?page=other_file_list";
	$pagination = new Pagination($sql1, $rowsperpage, $website, $dbconnect);
	$pagination->setPage($_GET['page1']);
	$pageList =$pagination->showPage();
	
	$sql_list = "select * from tbl_other_files order by page_id asc limit " . $pagination->getLimit() . ", " . $rowsperpage;
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
			$dparameter1=$result_list['parameter1'];
			$dparameter2=$result_list['parameter2'];
			$dparameter3=$result_list['parameter3'];
			$dparameter4=$result_list['parameter4'];
			$prefix1=$result_list['prefix'];	
			
			$text .= "<tr class='table_row1'>
				<td align='center' height=22>$cols</td>	
				<td align='left' height=22><a href='index.php?page=other_file_list&id=$result_list[id]' class='top_lightblue_link'>&nbsp;&nbsp;".$prefix1."</a></td>
				<td align='left' height=22><a href='index.php?page=other_file_list&id=$result_list[id]' class='top_lightblue_link'>&nbsp;&nbsp;".$file_name."</a></td>
				<td align='left' height=22><a href='index.php?page=other_file_list&id=$result_list[id]' class='top_lightblue_link'>&nbsp;&nbsp;".$dparameter1."</a></td>
				<td align='left' height=22><a href='index.php?page=other_file_list&id=$result_list[id]' class='top_lightblue_link'>&nbsp;&nbsp;".$dparameter2."</a></td>
				<td align='left' height=22><a href='index.php?page=other_file_list&id=$result_list[id]' class='top_lightblue_link'>&nbsp;&nbsp;".$dparameter3."</a></td>
				<td align='left' height=22><a href='index.php?page=other_file_list&id=$result_list[id]' class='top_lightblue_link'>&nbsp;&nbsp;".$dparameter4."</a></td>
				<td align='center'><input name='checkList[]' type='checkbox' value='$result_list[id]'><input type='hidden' name='checkList[]' id='checkList[]' value='0'></td>
			</tr>";		  
			$cols++;
		}
	} 
	else {
		$text .= "<tr class='table_row'><td align='center' height=22 colspan='7'><font color='red'>No such a record found.</font></td></tr>";
	}
	include $htmlfile."other_file_list.html";
?>	