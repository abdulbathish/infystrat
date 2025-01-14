<table width="170" border="0" align="left" cellpadding="0" cellspacing="0">
<tr>
	<td valign="top" id="left_section">
	<?php
		$sel_access = "select * from admin_user_type where id='$_SESSION[user_type]'";
		$res_access = q($sel_access,$dbconnect);
		$row_access = f($res_access);		
		$exp_access_module = explode("-",$row_access['user_access']);
		$page_name = $_GET["page"];
	?>
	<div id="left_menu">
		<ul>
			<?php if($page_name==""){?>
				<li class="current"><a href="index.php"><span>Admin Home</span></a></li>
				<?php }else{?>
				<li><a href="index.php"><span>Admin Home</span></a></li>
			<?php }?>
			<?php 
			if($_SESSION["loginname"]!=""){  
			for($i=0;$i<count($exp_access_module);$i++)
			{
			?>
				<?php if(preg_match("/page_mgn/", $exp_access_module[$i])){ ?>
					<?php if($page_name=="page_list" || $page_name=="page_details"){?>		
						<li class="current"><a href="index.php?page=page_list"><span>General Pages</span></a></li>
					<?php }else{?>
						<li><a href="index.php?page=page_list"><span>General Pages</span></a></li>
					<?php }?>
				<?php } ?>

				<?php if(preg_match("/master_mgn/", $exp_access_module[$i])){ ?>
					<?php if($page_name=="contactus_mail_list" || $page_name=="contactus_mail_details"){?>	
						<li class="current"><a href="index.php?page=contactus_mail_list"><span>Mail Master</span></a></li>
					<?php }else{?>
						<li><a href="index.php?page=contactus_mail_list"><span>Mail Master</span></a></li>
					<?php }?>
				<?php } ?>	
                
                <?php if(preg_match("/slideshow_mgn/", $exp_access_module[$i])){ ?>
					<?php if($page_name=="homebanner_list" || $page_name=="homebanner_details"){?>
						<li class="current"><a href="index.php?page=homebanner_list"><span>Slideshow</span></a></li>
						<?php }else{?>
						<li><a href="index.php?page=homebanner_list"><span>Slideshow</span></a></li>
					<?php }?>
				<?php } ?>

				<?php if(preg_match("/event_mgn/", $exp_access_module[$i])){ ?>
					 <?php if($page_name=="event_list" || $page_name=="event_details" ){?>
						<li class="current"><a href="index.php?page=event_list"><span>News & Event Management</span></a></li>
					 <?php }else{?>
					 	<li><a href="index.php?page=event_list"><span>News & Event Management</span></a></li>
					 <?php }?>
				<?php } ?>
                
				<?php if(preg_match("/recruitment_mgn/", $exp_access_module[$i])){ ?>
					 <?php if($page_name=="career_master_list" || $page_name=="job_list" || $page_name=="job_details" || $page_name=="career_job_apply_list" || $page_name=="career_job_apply_details"){?>
						<li class="current"><a href="index.php?page=career_master_list"><span>Recruitment Management</span></a></li>
					 <?php }else{?>
					 	<li><a href="index.php?page=career_master_list"><span>Recruitment Management</span></a></li>
					 <?php }?>
				<?php } ?>
                
				<?php if(preg_match("/download_mgn/", $exp_access_module[$i])){ ?>
					 <?php if($page_name=="download_list" || $page_name=="download_details" ){?>
						<li class="current"><a href="index.php?page=download_list"><span>Download Section</span></a></li>
					 <?php }else{?>
					 	<li><a href="index.php?page=download_list"><span>Download Section</span></a></li>
					 <?php }?>
				<?php } ?>
                
				<?php if(preg_match("/partners_mgn/", $exp_access_module[$i])){ ?>
					 <?php if($page_name=="partners_list" || $page_name=="partners_details" ){?>
						<li class="current"><a href="index.php?page=partners_list"><span>Partners</span></a></li>
					 <?php }else{?>
					 	<li><a href="index.php?page=partners_list"><span>Partners</span></a></li>
					 <?php }?>
				<?php } ?>
                
                <?php if(preg_match("/contact_mgn/", $exp_access_module[$i])){ ?>
					<?php if($page_name=="contactus" || $page_name=="contactus_details" ){?>
						<li class="current"><a href="index.php?page=contactus"><span>Contact Form Entries</span></a></li>
					<?php }else{?>
						<li><a href="index.php?page=contactus"><span>Contact Form Entries</span></a></li>
					<?php }?>
				<?php } ?>
				
				<?php if(preg_match("/social_mgn/", $exp_access_module[$i])){ ?>
					<?php if($page_name=="social_links"){?>
						<li class="current"><a href="index.php?page=social_links"><span>Social Media Links</span></a></li>
					<?php }else{?>
						<li><a href="index.php?page=social_links"><span>Social Media Links</span></a></li>
					<?php }?>
				<?php } ?>
					
				<?php if(preg_match("/location_mgn/", $exp_access_module[$i])){ ?>
					<?php if($page_name=="google_map_list"){?>
						<li class="current"><a href="index.php?page=google_map_list"><span>Location Map</span></a></li>
					<?php }else{?>
						<li><a href="index.php?page=google_map_list"><span>Location Map</span></a></li>
					<?php }?>
				<?php } ?>
				
				<?php if(preg_match("/site_mgn/", $exp_access_module[$i])){ ?>
					<?php if($page_name=="site_configuration"){?>
						<li class="current"><a href="index.php?page=site_configuration"><span>Site Configuration</span></a></li>
					<?php }else{?>
						<li><a href="index.php?page=site_configuration"><span>Site Configuration</span></a></li>
					<?php }?>
				<?php } ?>

				<?php if(preg_match("/admin_user_mgn/", $exp_access_module[$i])){ ?>
					<li>&nbsp;</li>
					 <?php if($page_name=="admin_master" || $page_name=="admin_user_type_list" || $page_name=="admin_user_type_details" || $page_name=="admin_user_list" || $page_name=="admin_user_details" || $page_name=="user_authentication_list"){?>
						<li class="current"><a href="index.php?page=admin_master"><span>User Management</span></a></li>
					<?php }else{?>	
						<li><a href="index.php?page=admin_master"><span>User Management</span></a></li>
					<?php }?>		
				<?php } ?>

				<?php if(preg_match("/password_mgn/", $exp_access_module[$i])){ ?>
					<?php if($page_name=="admin_settings"){?>					
						<li class="current"><a href="index.php?page=admin_settings"><span>Change Admin Password</span></a></li>
					<?php }else{?>
						<li><a href="index.php?page=admin_settings"><span>Change Admin Password</span></a></li>
					<?php }?>	
				<?php } ?>				

			<?php }//for($i=0;$i<count($exp_access_module)-1;$i++)
		}// if($_SESSION["user_type"]!=""){ 
		?>	
			<!--<li><a href="index.php?page=seo_page_rules"><span>SEO page Management</span></a></li>-->
			<li><a href="index.php?page=logout"><span>Logout</span></a></li>					
		</ul>
	</div>
	
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>