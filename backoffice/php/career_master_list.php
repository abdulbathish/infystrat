<?php
	
	$sql1 = "select * from tbl_job_apply order by id desc";
	$qry = q($sql1,$dbconnect);
	$rcount = nr($qry);
	include $htmlfile."career_master_list.html";
?>
