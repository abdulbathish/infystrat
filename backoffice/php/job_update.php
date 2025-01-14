<?php
if($access_job==0) { header("location:index.php"); }
if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'] )
{  
  $id= $_POST['id'];   
  
  //English data
  $jobname = str_replace("'","&rsquo;",$_POST['txtjobname']);
  $noofpos = str_replace("'","&rsquo;",$_POST['txtnoofpos']);
  $location = str_replace("'","&rsquo;",$_POST['txtlocation']);
  $description = str_replace("'","&rsquo;",$_POST['description']);
  
  //Spanish data
  $picture_alt = str_replace("'","&rsquo;",$_POST['image_alt']);
  
  $sethome = $_POST['txtsethome'];
  $active = $_POST['active'];
  
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
	$config['image_uploads_path'] = 'job_images';
	$config['image_uploads_url'] =  'job_images'; 
	
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
  		 
		$uploadpath="../job_images/".$rand."_".$name1;
		@move_uploaded_file($tmpfname,$uploadpath)or die("<br>image not upload");
		$filepath="../job_images/".$rand."_".$name1;	
		$imgname = $rand."_".$name1;
		
		    if($id!="" || $id!=0)
			{
				$sel_img = "select picture from tbl_job where fld_id='$id'";
				$res_img = q($sel_img,$dbconnect);
				$row_img = f($res_img);
				$img_name = $row_img[0];
				@unlink("../job_images/".$img_name);
				@unlink("../job_images/thumb0/".$img_name);
			}	
		
		//-------- Code to creating thumbnail (start) -----------------------------------
			$imgInfo = @getImageSize($filepath);
			for($i=0;$i<2;$i++)
			{
				$thumnail_path = "../job_images/thumb".$i."/".$imgname;
				$thumbnail = $manager->getThumbName($thumnail_path);
				switch($i)
				{
					case 0 : $height = 200; $width = 250;
							$thumbnailer = new Thumbnail($width,$height);
							$thumbnailer->createThumbnail("".$filepath, $thumbnail,$width,$height);
							break;
					case 1 : $height = 413; $width = 620;
							$thumbnailer = new Thumbnail($width,$height);
							$thumbnailer->createThumbnail("".$filepath, $thumbnail,$width,$height);
							break;
				}	//switch($i)		
			}//for($i=0;$i<2;$i++) 
	 	 }
  
  if($id == '') {
   // $tap_date_count = nr(q("select * from news where tap='$tap'"));
   	$sql = "insert into tbl_job( fld_id, 
							fld_jobname,
							fld_position,
							fld_location,
							fld_description,
							picture,
							picture_alt,
							fld_sethome,
							fld_status,
							fld_postdate)
						values('',
							'$jobname',
							'$noofpos',
							'$location',
							'$description',
							'$imgname',
							'$picture_alt',
							'$sethome',
							'1',
							now())";
	}
	else
	{
		if($_FILES['picture']['name']!="")
		{
			$sql = "update tbl_job set fld_jobname='$jobname',fld_position='$noofpos',fld_location='$location',fld_description='$description',picture='$imgname',picture_alt='$picture_alt',fld_sethome='$sethome' where fld_id='$id'";
		}else{
			$sql = "update tbl_job set fld_jobname='$jobname',fld_position='$noofpos',fld_location='$location',fld_description='$description',picture_alt='$picture_alt',fld_sethome='$sethome' where fld_id='$id'";
		}
	}
	//echo $sql;die();
if(q($sql,$dbconnect))
{
  	if($id=="" || $id==0)
	{
		$msg = "Job added successfully";
		$inserted_id=mysql_insert_id();
	}else{
		$msg = "Job updated successfully";
		$inserted_id=$id;
	}
	
	/*if($sethome==1){
		$sql = "update tbl_job set fld_sethome='1' where fld_id=$default_id";
		$sql1 = "update tbl_job set fld_sethome='0' where fld_id != $default_id";
	}*/
?>
 <script language="JavaScript">
  window.location="index.php?page=job_list&msg=<?php echo $msg?>";
 </script>

<?php
}
 else
 {
?>  
 <script language="JavaScript">
  window.document.location.href="index.php?page=job_list&msg_error=Jobs add failed";
  </script>
<?php
 }
}
?>