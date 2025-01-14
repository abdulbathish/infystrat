<?php
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
	$config['image_uploads_path'] = 'download_images';
	$config['image_uploads_url'] =  'download_images'; 
	
	$manager = new ImageManager($IMConfig);
	
	//------- Code for thumbnail creating (end) ------------------	
	 //upload pdf
		if($_FILES['pdf']['tmp_name']!="")
		{
			$rand=rand(0,1000);		
			
			$tmpfname=$_FILES['pdf']['tmp_name'];
			$name3=$_FILES['pdf']['name'];
			$ftype=$_FILES['pdf']['type'];
			$fsize=$_FILES['pdf']['size'];
			$size_kb = round($fsize/1024);
			$err='';
			$pos=strrpos($name3,".");
			$ispdf=strtolower(substr($name3,$pos+1,strlen($name3)-$pos));
			if($ispdf!="pdf" && $ispdf!="PDF")
			{
				$err1="Please upload correct format(Ex.pdf,PDF)";
		    }
			if ($fsize > 2048000)
			{
				$err1="pdf size is too big, Maximum size is 20 MB";
			}
			 //-tO delete an image --------
			 
			$uploadpath="../download_images/".$rand."_".$name3;
			@move_uploaded_file($tmpfname,$uploadpath)or die("<br>pdf not upload");
			$filepath="../download_images/".$rand."_".$name3;	
			$pdfname = $rand."_".$name3;
		
		    if($id!="" || $id!=0)
			{
				$sel_pdf = "select fld_pdf from tbl_download where fld_id='$_GET[dpdf]'";
				$res_pdf = q($sel_pdf,$dbconnect);
				$row_pdf = f($res_pdf);
				$pdf_name = $row_pdf[0];
				 
				@unlink("../download_images/".$pdf_name);
			}	
		}
	
  $title = str_replace("'","&rsquo;",$_POST['txttitle']);
  $intro_text = str_replace("'","&rsquo;",$_POST['txtintro_text']);
  
  if($id == '') 
  {
		$sql = "insert into tbl_download(fld_id,
					 fld_title,
					 fld_intro_text,
					 fld_pdf,
					 fld_status,									 									
					 fld_postdate)
			  values('',
					 '$title',
					 '$intro_text',
					 '$pdfname',
					 '1',
					 now())";
  }
  else 
  {
	if($_FILES['pdf']['tmp_name']!="")
	{
		$where = ",fld_pdf='$pdfname'";
	}else{
		$where = "";
	}
    $sql = "update tbl_download
				set fld_title='$title',
					fld_intro_text='$intro_text'
					".$where."
					where fld_id='$id'";
  } 
  //echo $sql;die();
if(q($sql,$dbconnect))
{
	if($id==''){
?>
	 <script language="JavaScript">
	 	window.document.location.href="index.php?page=download_list&msg=Record added successfully";
	 </script>
<?php } else { ?>
	 <script language="JavaScript">
	 	window.document.location.href="index.php?page=download_list&msg=Record updated successfully";
	 </script>
<?	}
 }
 else
 {
?>  
  <script language="JavaScript">
  	window.document.location.href="index.php?page=download_list&msg_error=Download add failed";
  </script>
<?php
 }
?>