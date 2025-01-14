<?php
	if($access_siteconf==0) { header("location:index.php"); die(); }
	
	$sel_site = "select * from site_configuration";
	$res_site = q($sel_site,$dbconnect);
	$res_row = f($res_site);
	
	$is_seo_url=$res_row['is_seo_friendly_url'];

	if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] )
	{ 
		if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']!="")
		{
			$site_url = utf8_encode($_POST['site_url']);
			$site_name = utf8_encode($_POST['site_name']);
			$footer_text = utf8_encode($_POST['footer_text']);	
			$front_footer = utf8_encode($_POST['front_footer']);	
			$permalinks = $_POST['permalinks'];			  
			
			$qu = q("update site_configuration set site_url='$site_url', site_name='$site_name', footer_text='$footer_text', front_footer='$front_footer', is_seo_friendly_url='$permalinks' where id='1'",$dbconnect);
			
			if($qu)
			{
				$file='../.htaccess';
				if($permalinks=='default'){
					file_put_contents($file, 'RewriteEngine On');
				}else{
					file_put_contents($file, 'RewriteEngine On');

					$domain_name = preg_replace("/www./","",$_SERVER['SERVER_NAME']);		
					
					//if(preg_match("/www/", $site_url)){
					//	$site_url_new = $site_url;
					//} else {
					//	$site_url_new = preg_replace("/http:\/\//","http://www.",$site_url);	
					//}

					if(preg_match("/[^.]+\.[^.]+$/", $domain_name)){						
						if(preg_match("/www/", $site_url)){							
							
							//put temp index.html file
							//$rule_filename_cond="\n".'DirectoryIndex index.html'."\n";
							//file_put_contents($file, $rule_filename_cond, FILE_APPEND | LOCK_EX);	

							//put www domain name
							$rule_site_cond="\n".'RewriteCond %{HTTP_HOST} ^'.$domain_name.' [NC]'."\n";
							file_put_contents($file, $rule_site_cond, FILE_APPEND | LOCK_EX);	
							
							$rule_site="\n".'RewriteRule ^(.*)$ '.$site_url.'$1 [R=301,L]'."\n";
							file_put_contents($file, $rule_site, FILE_APPEND | LOCK_EX);	
						}
					}

					$qry_pages=q("select * from general_pages order by id",$dbconnect);
					while($pages=f($qry_pages)){
					
						$page_file_details=f(q("select * from tbl_page_file where page_id=$pages[id]",$dbconnect));
						$hurl_name=replace_url($pages['page_title']);
						
						if($pages['url_title']!="")
						{
							$url_str=replace_url($pages['url_title']);
						}else{
							$url_str=$hurl_name;
						}
						
						if($page_file_details['page_file_name']=="")
						{
							//$file_name='general_page.php';
						}else
						{
							$file_name=$page_file_details['page_file_name'];
						}
						
						if($page_file_details['parameter1']!="")
						{
							$parameter=$page_file_details['parameter1'];
						}else{
							$parameter="pageid";
						}	
						
						$rule="\n".'RewriteRule ^'.$url_str.'$ '.$file_name.'?'.$parameter.'='.base64_encode($pages['id']).' [L]'."\n";
						file_put_contents($file, $rule, FILE_APPEND | LOCK_EX);	
						
					}	
					
					$qry_storepages=q("select * from store_general_pages order by id",$dbconnect);
					while($store_pages=f($qry_storepages)){
					
						$storepage_file_details=f(q("select * from tbl_page_file where store_page_id=$store_pages[id]",$dbconnect));
						$hurl_name=replace_url($store_pages['page_title']);
						
						if($store_pages['url_title']!="")
						{
							$url_str=replace_url($store_pages['url_title']);
						}else{
							$url_str=$hurl_name;
						}
						
						if($storepage_file_details['page_file_name']=="")
						{
							$file_name='general_page.php';
						}else
						{
							$file_name=$storepage_file_details['page_file_name'];
						}
						
						if($storepage_file_details['parameter1']!="")
						{
							$parameter=$storepage_file_details['parameter1'];
						}else{
							$parameter="pageid";
						}	
						
						$rule="\n".'RewriteRule ^'.$url_str.'$ '.$file_name.'?'.$parameter.'='.base64_encode($store_pages['id']).' [L]'."\n";
						file_put_contents($file, $rule, FILE_APPEND | LOCK_EX);	
						
					}
					
					$qry_other_pages=q("select * from tbl_other_files order by id",$dbconnect);
					while($otherpages=f($qry_other_pages)){
						$file='../.htaccess';
						$page_details1=f(q("select page_title, url_title from general_pages where id=$otherpages[page_id]",$dbconnect));
						
						$file_name_up=$otherpages['page_file_name'];
						$para1=$otherpages['parameter1'];
						$para2=$otherpages['parameter2'];
						$para3=$otherpages['parameter3'];
						$para4=$otherpages['parameter4'];
						
						$hurl_name=replace_url($page_details1['page_title']);
						$hurl_title=replace_url($page_details1['url_title']);
														
						$url_prefix=$otherpages['prefix'];
												
						$file_name=$file_name_up;
						
						if($para1!="")
						{
							$param1="$para1=".base64_encode($otherpages[page_id]);
						}else
						{
							$param1="pageid=".base64_encode($otherpages[page_id]);
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
					}
				}				
				echo "<script>window.location='index.php?page=site_configuration&msg=Site Settings Updated Successfully'</script>";
			}
			else
			{
				echo "<script>window.location='index.php?page=site_configuration&msg_error=Site Settings Not Updation Failed'</script>";
			}
		
		}// if(isset($_POST['btnSubmit']))
			
		
	}
	
		include $htmlfile."site_configuration.html";
?>
