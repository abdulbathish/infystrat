<?php
if($access_partners==0) { header("location:index.php"); }
  $id = $_POST['id']; 
    //------- Code for thumbnail creating (start) ------------------
	require_once('../Class/Thumbnail_new.php');
	require_once('../Class/ImageManager.php');
	
	#--------------
	#Image Settings
	#--------------
	$config['root_url'] = '';
	$config['image_manipulation_prog'] = 'GD';
	$config['image_transform_lib_path'] = '/usr/bin/ImageMagick/';
	
	#Default path and URL for uploaded images in the image manager
	$config['image_uploads_path'] = 'partners_images';
	$config['image_uploads_url'] =  'partners_images'; 
	
	$manager = new ImageManager($IMConfig);
	
	//------- Code for thumbnail creating (end) ------------------	
		
		if($_FILES['picture']['tmp_name']!="")
		{
			$rand=rand(0,1000);		
			$cdate = date('d-M-Y',time());
			$tmpfname=$_FILES['picture']['tmp_name'];
			$name1=$_FILES['picture']['name'];
			$ftype=$_FILES['picture']['type'];
			$fsize=$_FILES['picture']['size'];
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
  		 
		$uploadpath="../partners_images/".$rand."_".$name1;
		@move_uploaded_file($tmpfname,$uploadpath)or die("<br>image not upload");
		$filepath="../partners_images/".$rand."_".$name1;	
		$imgname = $rand."_".$name1;
		
		    if($id!="" || $id!=0)
			{
				$sel_img = "select picture from partners where id='$id'";
				$res_img = q($sel_img,$dbconnect);
				$row_img = f($res_img);
				$img_name = $row_img[0];
				@unlink("../partners_images/".$img_name);
				@unlink("../partners_images/thumb0/".$img_name);
				@unlink("../partners_images/thumb1/".$img_name);
			}	
		
		//-------- Code to creating thumbnail (start) -----------------------------------
			$imgInfo = @getImageSize($filepath);
			for($i=0;$i<1;$i++)
			{
				$thumnail_path = "../partners_images/thumb".$i."/".$imgname;
				$thumbnail = $manager->getThumbName($thumnail_path);
				switch($i)
				{
					case 0 : $height = 144; $width = 220;
							$thumbnailer = new Thumbnail($width,$height);
							$thumbnailer->createThumbnail("".$filepath, $thumbnail,$width,$height);
							break;
				}	//switch($i)		
			}//for($i=0;$i<2;$i++) 
	 	 }
  
  $partners_name = str_replace("'","&rsquo;",$_POST['partnersname']);
  $partners_name_ne = str_replace("'","&rsquo;",$_POST['partnersname_ne']);
  $picture_alt = str_replace("'","&rsquo;",$_POST['image_alt']);

  $url_title1 = str_replace("'","&rsquo;",$_POST['url_title']);
  $url_title = strtolower(str_replace("’","&rsquo;",$url_title1));
  $homeset = $_POST['txthomeset'];

  if($id == '') 
  {
		$sql = "insert into partners(id,
								 partners_name,
								 url_title,
								 picture,
								 picture_alt,
								 fld_showhome,
								 status,									 									
								 postdate) 										
						  values('',
								 '$partners_name',
								 '$url_title',
								 '$imgname',
								 '$picture_alt',
								 '$homeset',
								 '1',
								 now())";  
  } 
  else 
  { 
  
  	if($_FILES['picture']['name']!="")
	{
	    $sql = "update partners 
					set partners_name='$partners_name',
						url_title='$url_title', 
					 	picture='$imgname',
						picture_alt='$picture_alt',
						fld_showhome='$homeset',
						postdate=now()
					where id='$id'";
	}
	else
	{
		$sql = "update partners 
					set partners_name='$partners_name',
						url_title='$url_title',
						picture_alt='$picture_alt',
						fld_showhome='$homeset',
						postdate=now() 
					where id='$id'";
	}
		
  } 
  //echo $sql;
  //die();
if(q($sql,$dbconnect))
{
	if($id==''){
?>
	 <script language="JavaScript">
	 	window.document.location.href="index.php?page=partners_list&msg=Partners added successfully";
	 </script>
<?php } else { ?>
	 <script language="JavaScript">
	 	window.document.location.href="index.php?page=partners_list&msg=Partners updated successfully";
	 </script>
<?	}
 }
 else
 {
?>  
  <script language="JavaScript">
  	window.document.location.href="index.php?page=partners_list&msg_error=Partners add failed";
  </script>
<?php
 }
?>