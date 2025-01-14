<?php
	ob_start(); 
	session_start();

	include "../db/mysql.php";
	include "../db/config.php";
		
	$today_date = time();
	
	$sql = "select * from tbl_job_apply order by id DESC";
	$qry = q($sql,$dbconnect);
		
	$out.="Sr.No., Apply for, Applier Name,  Applier Email, Phone, Message, Application Date\r\n";
	
	if(nr($qry)>0) 
	{	
		$i=1;
		while ($rr = f($qry))
		{
			$sel_job = "select fld_jobname from tbl_job where fld_id='$rr[jobid]'";
			$res_job = q($sel_job,$dbconnect);
			$row_job = f($res_job);
			$job_name = str_replace(","," ",$row_job['fld_jobname']);
			
			$applyfor = str_replace(","," ",$rr['apply_for']);		
			$fname = str_replace(","," ",$rr['applier_name']);			
			$email = $rr['email'];			
			$phone = $rr['phone'];											
			$motivation1 = str_replace(","," ",$rr['resume']);
			$motivation = str_replace("\r\n"," ", $motivation1);						
			$application_date = date('m-d-Y',strtotime($rr['apply_date']));			
			
			$out.="$i, $job_name, $fname, $email, $phone, $motivation, $application_date \r\n";
			$i++;
			
		}//	while ($result = f($qry))	
	}//if(nr($qry)>0)
	
	$today_date = date("d-m-Y");
	$file_name = "Application_Report_".$today_date.".csv";

	header("Content-type: text/x-csv");
	header("Content-Disposition: attachment; filename=$file_name");
	echo $out;
	exit;
?>