<?php
	$id = $_GET['id'];
	$jobid1= $_GET['job_id'];	
	
	$sql = "select * from tbl_job_apply where id = $id";
	$qry = q($sql,$dbconnect);
	$result = f($qry);

	$apply_for=$result['apply_for'];	
	$jobid = $result['jobid'];
	$applier_name = $result['applier_name'];
	$email = $result['email'];
	$phone = $result['phone'];
	$apply_date = $result['apply_date'];
	$resume=$result['resume'];

	$resume_cv = "../job_images/".$result['job_cv'];
	
	//------ display job name ----
	$sel_job = "select fld_jobname from tbl_job where fld_id='$jobid'";
	$res_job = q($sel_job,$dbconnect);
	$row_job = f($res_job);
	$job_name = $row_job['fld_jobname'];
	
	include $htmlfile."career_job_apply_details.html";
		
?>
