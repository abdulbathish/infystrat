<?php
if($access_page==0) { header("location:index.php"); die(); }
	
if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] )
{
	  if($_POST['pageid']!=''){
		$pageid = $_POST['pageid'];
	  }else{
		$pageid = $_GET['pageid'];
	  }
	  
	  $id= $_POST['id'];
	  $parent= $_POST['parent'];
	  
	  $page_title1 = str_replace("'","&rsquo;",$_POST['page_title']);
	  $page_title = str_replace("’","&rsquo;",$page_title1);

      $url = $_POST['txturl'];

	  $browser_title1 = str_replace("'","&rsquo;",$_POST['browser_title']);
	  $browser_title = str_replace("’","&rsquo;",$browser_title1);
	  
	  $intro_text = str_replace("'","&rsquo;",$_POST['intro_text']);
	
	  $description = str_replace("'","&rsquo;",$_POST['description']);

	  $meta_keywords1 = str_replace("'","&rsquo;",$_POST['meta_keywords']);
	  $meta_keywords = str_replace("’","&rsquo;",$meta_keywords1);

	  $meta_description1 = str_replace("'","&rsquo;",$_POST['meta_description']);
	  $meta_description = str_replace("’","&rsquo;",$meta_description1);

      $page_subtitle1 = str_replace("'","&rsquo;",$_POST['page_subtitle']);	
	  $page_subtitle = str_replace("’","&rsquo;",$page_subtitle1);	
	  
	  $image_alt1 = str_replace("'","&rsquo;",$_POST['image_alt']);
	  $image_alt = str_replace("’","&rsquo;",$image_alt1);
	  
 	  $listing_title1 = str_replace("'","&rsquo;",$_POST['listing_title']);
	  $listing_title = str_replace("’","&rsquo;",$listing_title1);
		
	  $url_title1 = str_replace("'","&rsquo;",$_POST['url_title']);
	  $url_title = strtolower(str_replace("’","&rsquo;",$url_title1));

	  $status = $_POST['txtstatus'];
	  $order = $_POST['txtorder'];
	  
  
  //------- Code for thumbnail creating (start) ------------------
		require_once('../Class/Thumbnail_new.php');
		require_once('../Class/ImageManager.php');
		
		$config['root_url'] = '';

		$config['image_manipulation_prog'] = 'GD';
		$config['image_transform_lib_path'] = '/usr/bin/ImageMagick/';

		#Default path and URL for uploaded images in the image manager
		$config['image_uploads_path'] = 'general_image';
		$config['image_uploads_url'] =  'general_image'; 

		$manager = new ImageManager($IMConfig);
		//------- Code for thumbnail creating (end) ------------------
		@chmod("../general_image/thumb0", 0777);

		if($_FILES['picture']['tmp_name']!=""){
		$rand=rand(0,1000);
		$cdate = date('d-M-Y',time());
		$tmpfname=  str_replace(" ","",$_FILES['picture']['tmp_name']);//$_FILES['photo']['tmp_name'];
		$name1= str_replace(" ","",$_FILES['picture']['name']);//$_FILES['photo']['name'];
		$ftype=$_FILES['picture']['type'];
		$fsize=$_FILES['picture']['size'];
		$size_kb = round($fsize/1024);
		$err='';
		$pos=strrpos($name1,".");
		$imageformat=strtolower(substr($name1,$pos+1,strlen($name1)-$pos));
		if($imageformat!="jpg" && $imageformat!="gif" && $imageformat!="png" && $imageformat!="bmp" && $imageformat!="swf"){
		$err="Please upload image correct format(Ex.jpg,gif,png,bmp,swf)";
		}
		if ($fsize > 5242880){
		$err="Image size is too big, Maximum size is 5 MB";
		}
  		if($id!=0)
		{
			$sel_img = "select picture from general_pages where id='$id'";
			$res_img = q($sel_img,$dbconnect);
			$row_img = f($res_img);
			$img_name = $row_img[0];
			@unlink("../general_image/".$img_name);
			@unlink("../general_image/thumb0/".$img_name);
		}
		$uploadpath="../general_image/".$rand."_".$name1;
		@move_uploaded_file($tmpfname,$uploadpath)or die("<br>image not upload");
		$filepath="../general_image/".$rand."_".$name1;	
		$imgname = $rand."_".$name1;
		
		//-------- Code to creating thumbnail (start) -----------------------------------
		
			$imgInfo = @getImageSize($filepath);
			for($i=0;$i<2;$i++)
			{
			    
				$thumnail_path = "../general_image/thumb".$i."/".$imgname;
				$thumbnail = $manager->getThumbName($thumnail_path);
				switch($i)
				{
					case 0 : $height =180 ; $width =235; 
							$thumbnailer = new Thumbnail($width,$height);
							$thumbnailer->createThumbnail("".$filepath, $thumbnail,$width,$height);
							break;
				}	//switch($i)		
			}//for($i=0;$i<2;$i++)
			//-------- Code to creating thumbnail (end) -----------------------------------
		}

if($id=="" || $id==0) 
{
	$sql = "insert into general_pages(`id`,`parent_id`,`page_title`,`page_subtitle`,`url`,`browser_title`,`intro_text`,`url_title`,`meta_keywords`,`meta_description`,`picture`,`image_alt`,`listing_title`,`description`,`status`) values('','$parent','$page_title','$page_subtitle','$url','$browser_title','$intro_text','$url_title','$meta_keywords','$meta_description','$imgname','$image_alt','$listing_title','$description',1)";
} else {
	if($_FILES['picture']['name']!="")
	{
		$sql = "update `general_pages` set `page_title`='$page_title', `page_subtitle`='$page_subtitle', `url`='$url',` browser_title`='$browser_title', `intro_text`='$intro_text', `url_title`='$url_title', `meta_keywords`='$meta_keywords', `meta_description`='$meta_description', `picture`='$imgname', `image_alt`='$image_alt',`listing_title`='$listing_title', `description`='$description' where `id`='$id' and `parent_id`='$parent'";
	}	
	else
	{
		 $sql = "update `general_pages` set `page_title`='$page_title', `page_subtitle`='$page_subtitle', `url`='$url', `browser_title`='$browser_title', `intro_text`='$intro_text', `url_title`='$url_title', `meta_keywords`='$meta_keywords', `meta_description`='$meta_description', `image_alt`='$image_alt', `listing_title`='$listing_title', `description`='$description' where `id`='$id' and `parent_id`='$parent'";
	}
}
//echo $sql;die();
if(q($sql,$dbconnect))
{
 	if($id=="" || $id==0)
	{
		$new_id=mysql_insert_id();
		$inserted_id=$new_id;
				
		$file='../.htaccess';
		
		$hurl_name="sub_page.php";
		$sql_inst = "insert into tbl_page_file(id,page_id,page_file_name,parameter1,parameter2)values('','$new_id','$hurl_name','pageid','subpageid')";
		
		q($sql_inst,$dbconnect);
		
		if($url_title!="")
		{
			$url_str=replace_url($url_title);
		}else{
			$url_str=$hurl_name;
		}
		
		$file_name="general_page";
				
		$rule="\n".'RewriteRule ^'.$url_str.'$ '.$file_name.'.php?pageid='.base64_encode($new_id).' [L]'."\n";
		file_put_contents($file, $rule, FILE_APPEND | LOCK_EX);
	
		$msg = "Sub page added successfully.";		
	}else{
		
				
		$file='../.htaccess';
		$page_file_details=f(q("select page_file_name from tbl_page_file where page_id=$id",$dbconnect));
		
		$sql = "update tbl_page_file set page_id='$page_id', page_file_name='$file_name_up', parameter1='$para1' where id='$id'";
		
		$phurl_name=replace_url($previous_page['page_title']);
				
		if($previous_page['url_title']!="")
		{
			$url_str=replace_url($previous_page['url_title']);
		}else{
			$url_str=$phurl_name;
		}
			
		$file_name=$phurl_name;
		
		$search="RewriteRule ^".$url_str."$ ".$file_name.".php?pageid=".base64_encode($id)." [L]";
		$search2="RewriteRule ^".$url_str."$ ".$page_file_details['page_file_name']."?pageid=".base64_encode($id)." [L]";
		$fh = fopen($file, 'r');
		$olddata = fread($fh, filesize($file));
		
		if(strpos($olddata, $search)) {
			$newdata = str_replace($search,"",$olddata);
			file_put_contents($file, $newdata);
		}
		$fh = fopen($file, 'r');
		$newdata_str = fread($fh, filesize($file));
		
		if(strpos($newdata_str, $search2)) {
					
			$newdata2 = str_replace($search2,"",$newdata_str);
			file_put_contents($file, $newdata2);
		}else{
			//echo "Not";
		}
		
		fclose($fh);
		
		$file='../.htaccess';
		$hurl_name=replace_url($page_title);
		
		if($url_title!="")
		{
			$url_str=replace_url($url_title);
		}else{
			$url_str=$hurl_name;
		}
		
		if($page_file_details['page_file_name']!="")
		{
			$file_name=$page_file_details['page_file_name'];
		}else
		{
			$file_name=$hurl_name.".php";
		}
		
		$rule="\n".'RewriteRule ^'.$url_str.'$ '.$file_name.'?pageid='.base64_encode($id).' [L]'."\n";
		
		$fh = fopen($file, 'r');
		
		file_put_contents($file, $rule, FILE_APPEND | LOCK_EX);
		file_put_contents($file, implode('', file($file, FILE_SKIP_EMPTY_LINES)));
		fclose($fh);
	
		$msg = "Sub page updated successfully.";
		$inserted_id=$id;
	}
?>

 <script language="JavaScript">
  window.location="index.php?page=subpage_list&msg=<?php echo $msg?>&pageid=<?php echo $pageid;?>";
 </script>

<?php
 }
 else
 {
?>  
 <script language="JavaScript">
  window.location="index.php?page=subpage_list&msg_error=Sub page add failed.&pageid=<?php echo $pageid;?>";
  </script>
<?php
 }
}
?>
