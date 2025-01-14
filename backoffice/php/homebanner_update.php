<?php
if($access_banner==0) { header("location:index.php"); die(); }
	
if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] )
{ 
  $id = $_POST['id']; 
  $pageid = $_POST['pagecatid'];  
  $title = str_replace("'","&rsquo;",$_POST['title']); 
  $image_alt = str_replace("'","&rsquo;",$_POST['image_alt']);  
  $description = str_replace("'","&rsquo;",$_POST['description']); 	
    
  //------- Code for thumbnail creating (start) ------------------
	require_once('../Class/Thumbnail_new.php');
	require_once('../Class/ImageManager.php');
	 
	$config['root_url'] = '';
	 
	$config['image_manipulation_prog'] = 'GD';
	$config['image_transform_lib_path'] = '/usr/bin/ImageMagick/';
	 
	$config['image_uploads_path'] = 'banner_images';
	$config['image_uploads_url'] =  'banner_images'; 
	
	$manager = new ImageManager($IMConfig);
	//------- Code for thumbnail creating (end) ------------------	
 		
		if($_FILES['picture']['tmp_name']!="")
		{
			$rand = rand(0,1000);		
			$cdate = date('d-M-Y',time());
			$tmpfname = $_FILES['picture']['tmp_name'];
			$name1 = $_FILES['picture']['name'];
			$ftype = $_FILES['picture']['type'];
			$fsize = $_FILES['picture']['size'];
			$size_kb = round($fsize/1024);
			$err='';
			$pos=strrpos($name1,".");
			$imageformat=strtolower(substr($name1,$pos+1,strlen($name1)-$pos));
			if($imageformat!="jpg" && $imageformat!="gif" && $imageformat!="png" && $imageformat!="bmp" && $imageformat!="swf")
			{
				$err="Please upload image correct format(Ex.jpg,gif,png,bmp,swf)";
		    }
			if ($fsize > 5242880)
			{
				$err="Image size is too big, Maximum size is 5 MB";
			}
		
		 //-tO delete an image --------
  		 
		$uploadpath="../banner_images/".$rand."_".$name1;
		@move_uploaded_file($tmpfname,$uploadpath)or die("<br>image not upload");
		$filepath="../banner_images/".$rand."_".$name1;	
		$imgname = $rand."_".$name1;
		
		    if($id!="" || $id!=0)
			{
				$sel_img = "select picture from home_banners where id='$id'";
				$res_img = q($sel_img,$dbconnect);
				$row_img = f($res_img);
				$img_name = $row_img[0];
				@unlink("../banner_images/thumb0/".$img_name);	
				@unlink("../banner_images/thumb1/".$img_name);
				@unlink("../banner_images/".$img_name);
			}	
		
		//-------- Code to creating thumbnail (start) -----------------------------------
			$imgInfo = @getImageSize($filepath);
			for($i=0;$i<2;$i++)
			{
				$thumnail_path = "../banner_images/thumb".$i."/".$imgname;
				$thumbnail = $manager->getThumbName($thumnail_path);
				switch($i)
				{
					case 0 : $height = 50; $width = 75;
							$thumbnailer = new Thumbnail($width,$height);
							$thumbnailer->createThumbnail("".$filepath, $thumbnail,$width,$height);
							break; 
					case 1 : $height = 500; $width = 1600;
							$thumbnailer = new Thumbnail($width,$height);
							$thumbnailer->createThumbnail("".$filepath, $thumbnail,$width,$height);
							break; 						
				}	//switch($i)		
			}//for($i=0;$i<2;$i++) 
	 	 }
       
		if($id == '') {
	     
   	$sql = "insert into home_banners(id,
									title, 
									page_id ,									 
									picture,
									image_alt,
									description,
									status								 								 									
									) 
							
							values('',
								   '$title',
								   '$pageid', 
								   '$imgname',
								   '$image_alt',
								   '$description',
								   '1' 
								   )";  
		} 
		else 
		{ 
			if($_FILES['picture']['name']!="")
			{
			  $sql = "update home_banners set title='$title', page_id ='$pageid', picture='$imgname',image_alt='$image_alt', description='$description' where id='$id' ";
			} 
			else
			{
			$sql = "update home_banners set title='$title', page_id ='$pageid',image_alt='$image_alt', description='$description' where id='$id'";
			} 
	}	
	
	
if(q($sql,$dbconnect))
  {
	if($id==''){
?>
	 <script language="JavaScript">
	  window.document.location.href="index.php?page=homebanner_list&msg=Slideshow Banner added successfully";
	 </script>
<?php } else { ?>
	<script language="JavaScript">
	  window.document.location.href="index.php?page=homebanner_list&msg=Slideshow Banner updated successfully";
	 </script>
<?php	}
 }
 else
 {
?>  
 <script language="JavaScript">
  window.document.location.href="index.php?page=homebanner_list&msg_error=Slideshow Banner add failed";
  </script>
<?php
 }
}
?>
