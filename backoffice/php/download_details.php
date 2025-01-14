<?php
	$id = $_GET['id'];
	//delete pdf
	if(isset($_GET['dpdf']))
	{
		$sel_pdf = "select pdf from tbl_download where fld_id='$_GET[dpdf]'";
		$res_pdf = q($sel_pdf,$dbconnect);
		$row_pdf = f($res_pdf);
		$pdf_name = $row_pdf[0];
		
		@unlink("../download_images/".$pdf_name);		
		q("update tbl_download set pdf='' where fld_id='$_GET[dpdf]'",$dbconnect);
		echo "<script>window.location='index.php?page=download_details&id=$_GET[dpdf]'</script>";
	}
	$sql = "select * from tbl_download where fld_id=$id";
	$qry = q($sql,$dbconnect);
	$result = f($qry);

	$title = $result['fld_title'];
	$intro_text = $result['fld_intro_text'];

	if($result['fld_pdf']!="" && file_exists("../download_images/$result[fld_pdf]"))
	{
	   $pdfpath = "../download_images/$result[fld_pdf]";
	   $pdf_name = "<a href='javascript:void(0)' onClick='showImage(\"$pdfpath\")'>View PDF</a>&nbsp;|&nbsp;<a href='index.php?page=download_details&id=$id&dpdf=$id'>Delete PDF</a>";
	}

	include $htmlfile."download_details.html";
?>