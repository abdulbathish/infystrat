<?php
  $id = $_POST['id']; 

  $subject = str_replace("'","&rsquo;",$_POST['txtsubject']);
  $intro_text = str_replace("'","&rsquo;",$_POST['txtintro_text']);
  if($_POST['txteventdate']==''){
	$eventDate = '';
  }else{
	$eventDate = date("Y-m-d",strtotime($_POST['txteventdate']));
  }

  $description = str_replace("'","&rsquo;",$_POST['description']);

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
	$config['image_uploads_path'] = 'event_images';
	$config['image_uploads_url'] =  'event_images'; 

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
		 
		$uploadpath="../event_images/".$rand."_".$name1;
		@move_uploaded_file($tmpfname,$uploadpath)or die("<br>image not upload");
		$filepath="../event_images/".$rand."_".$name1;	
		$imgname = $rand."_".$name1;
		
			if($id!="" || $id!=0)
			{
				$sel_img = "select fld_picture from tbl_event where fld_id='$id'";
				$res_img = q($sel_img,$dbconnect);
				$row_img = f($res_img);
				$img_name = $row_img[0];
				@unlink("../event_images/".$img_name);
				@unlink("../event_images/thumb0/".$img_name);
				@unlink("../event_images/thumb1/".$img_name);
			}	
		
		//-------- Code to creating thumbnail (start) -----------------------------------
			$imgInfo = @getImageSize($filepath);
			for($i=0;$i<2;$i++)
			{
				$thumnail_path = "../event_images/thumb".$i."/".$imgname;
				$thumbnail = $manager->getThumbName($thumnail_path);
				switch($i)
				{
					case 0 : $height = 200; $width = 250;
							$thumbnailer = new Thumbnail($width,$height);
							$thumbnailer->createThumbnail("".$filepath, $thumbnail,$width,$height);
							break;
					case 1 : $height = 250; $width = 250;
							$thumbnailer = new Thumbnail($width,$height);
							$thumbnailer->createThumbnail("".$filepath, $thumbnail,$width,$height);
							break;
				}	//switch($i)
			}//for($i=0;$i<2;$i++) 
		 }
  
  if($id == '') 
  {
		$sql = "insert into tbl_event(fld_id,
					 fld_name,
					 fld_intro_text,
					 fld_date,
					 fld_description,
					 fld_picture,
					 fld_status,									 									
					 fld_postdate)
			  values('',
					 '$subject',
					 '$intro_text',
					 '$eventDate',
					 '$description',
					 '$imgname',
					 '1',
					 now())";
  } 
  else 
  {
	if($_FILES['picture']['tmp_name']!==''){
		$sql = "update tbl_event
					set fld_name='$subject',
						fld_intro_text='$intro_text',
						fld_date='$eventDate',
						fld_description='$description',
						fld_picture='$imgname'
						where fld_id='$id'";
	}else{
		$sql = "update tbl_event
					set fld_name='$subject',
						fld_intro_text='$intro_text',
						fld_date='$eventDate',
						fld_description='$description'
						where fld_id='$id'";
	}
  }
  //echo $sql;die();
if(q($sql,$dbconnect))
{
	if($id==''){
?>
	 <script language="JavaScript">
	 	window.document.location.href="index.php?page=event_list&msg=News and Event added successfully";
	 </script>
<?php } else { ?>
	 <script language="JavaScript">
	 	window.document.location.href="index.php?page=event_list&msg=News and Event updated successfully";
	 </script>
<?	}
 }
 else
 {
?>  
  <script language="JavaScript">
  	window.document.location.href="index.php?page=event_list&msg_error=News and Event add failed";
  </script>
<?php
 }
?>