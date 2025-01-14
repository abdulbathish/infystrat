<?php
	global $sel_site,$res_site,$res_row,$site_name,$footer_text,$qu;	
	$recid=0;
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
	$config['image_uploads_path'] = 'location_images';
	$config['image_uploads_url'] =  'location_images'; 
	
	$manager = new ImageManager($IMConfig);

	//------- Code for thumbnail creating (end) ------------------	
	//------- Code for thumbnail creating (end) ------------------	
	//------- To delete Image Start --//	
	if(isset($_GET['dimgN']))
	{
		$sel_img = "select imagename from tbllocationimg where id='$_GET[dimgN]'";
		$res_img = q($sel_img,$dbconnect);
		$row_img = f($res_img);
		$img_name = $row_img[0];
		 
		@unlink("../location_images/thumb0/".$img_name);
		@unlink("../location_images/".$img_name); 
		q("delete from tbllocationimg where id='$_GET[dimgN]'",$dbconnect);
		echo "<script>window.location='index.php?page=location_list&id=$_GET[id]'</script>";
	}
	//------- To delte Image End --//
	 $sql_img = "select * from tbllocationimg where locid=1 order by id asc";
	 $qry_img = q($sql_img,$dbconnect);
	 $numimg = nr($qry_img);	
	 if($numimg==0)
	 {
	   $numimg =1;
	 }  
	 
	 $i=1;
	while($img_result = f($qry_img))
	{
	    $img_id = $img_result['id'];
	   	$imgtitle = $img_result['imagename'];		
		
		if($img_result['imagename']!="" && file_exists("../location_images/$img_result[imagename]"))
		{  
		    $imageid = "imgfileid".$i;
			$$imageid = $img_id;
			
		    $imagepath = "imgpath".$i;
			$image_name = "img_name".$i;			
	   		$$imagepath = "../location_images/$img_result[imagename]";
			$imagepath_view = "../location_images/$img_result[imagename]";
			
		   	$$image_name = "<a href='javascript:void(0)' onClick='showImage(\"$imagepath_view\")'>View Image</a>&nbsp;|&nbsp;<a href='index.php?page=location_list&id=$id&dimgN=$img_id'>Delete Image</a>";
		}
		$i++;
	}
	
	$sel_site = "select * from tbllocation";
	$res_site = q($sel_site,$dbconnect);
	$res_row = f($res_site);
			
	if(isset($_POST['btnSubmit']))
	{
		$site_name = utf8_encode($_POST['site_name']);
		$footer_text = utf8_encode($_POST['footer_text']);				  
		
		$qu = q("update tbllocation set fldlocation='$site_name' where id='1'",$dbconnect);
		
		$curtrid = $_POST['curtrid'];	 	
		for($i_img = 1;$i_img<=$curtrid;$i_img++) {			 
		$imageName = "imgfile".$i_img;		
		$imgfileid = "imgfileid".$i_img;		 			
		if($_FILES[$imageName]['tmp_name']!="")
		{
			$rand=rand(0,1000);		
			$cdate = date('d-M-Y',time());
			$tmpfname=$_FILES[$imageName]['tmp_name'];
			$name1=$_FILES[$imageName]['name'];
			$ftype=$_FILES[$imageName]['type'];
			$fsize=$_FILES[$imageName]['size'];
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
			 
			$uploadpath="../location_images/".$rand."_".$name1;
			@move_uploaded_file($tmpfname,$uploadpath)or die("<br>image not upload".$_FILES[$imageName]["error"]);
			$filepath="../location_images/".$rand."_".$name1;	
			$imgname = $rand."_".$name1;
			
				$imgfileid = $_POST[$$imgfileid];
				if($imgfileid1!="" || $imgfileid1!=0)
				{
					$sel_img = "select imagename from tbllocationimg where id='$imgfileid'";
					$res_img = q($sel_img,$dbconnect);
					$row_img = f($res_img);
					$img_name = $row_img[0];
					if($img_name!=""){
						@unlink("../location_images/thumb0/".$img_name);
						@unlink("../location_images/".$img_name);
					
					   $updt_img = "update tbllocationimg set imagename = '$imgname'  where id='$imgfileid'";
						$res_img = q($updt,$dbconnect);
					}
					else
					{
					    $sql = "INSERT INTO `tbllocationimg` (`id` ,`locid` ,`imagename` ,`title`) VALUES ('', '1', '$imgname', 'Title');";
					q($sql,$dbconnect);
					}	
				}
				else
				{
					$sql = "INSERT INTO `tbllocationimg` (`id` ,`locid` ,`imagename` ,`title`) VALUES ('', '1', '$imgname', 'Title');";
					q($sql,$dbconnect);
				}	
			//-------- Code to creating thumbnail (start) -----------------------------------
				$imgInfo = @getImageSize($filepath);
				for($i=0;$i<2;$i++)
				{
					$thumnail_path = "../location_images/thumb".$i."/".$imgname;
					$thumbnail = $manager->getThumbName($thumnail_path);
					switch($i)
					{
					case 0 : $height = 167;$width = 250; 
								$thumbnailer = new Thumbnail($width,$height);
								$thumbnailer->createThumbnail("".$filepath, $thumbnail,$width,$height);
								break;
					/*case 1 : $height = 80;$width = 132; 
								$thumbnailer = new Thumbnail($width,$height);
								$thumbnailer->createThumbnail("".$filepath, $thumbnail,$width,$height);
								break;*/
					}	//switch($i)		
				}//for($i=0;$i<2;$i++) 
			 }		
	// $i_img++;
	}	
		
		if($qu)
		{
			echo "<script>window.location='index.php?page=location_list&msg=Location Updated Successfully'</script>";
		}
		else
		{
			echo "<script>window.location='index.php?page=location_list&msg_error=Location Not Updation Failed'</script>";
		}
	
	}// if(isset($_POST['btnSubmit']))
	
		include $htmlfile."location_list.html";
?>