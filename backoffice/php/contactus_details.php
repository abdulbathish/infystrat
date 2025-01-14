<?php
if($access_contact==0) { header("location:index.php"); }
	$cid = $_GET[cid];
	$sq = q("select * from contactus where cid='$cid'",$dbconnect);
	$rr = f($sq);
	
	$username= ucfirst($rr['fname']);
	$fname=ucfirst($rr['fname']);
	$email  = $rr['email'];
	$subject  = $rr['subject'];
	$message  = $rr['message'];
	$phone  = $rr['phone'];
		
	if($rr['stay_updated']==1)
	{ 
		$stay_updated = "Yes"; 
	}else{ 
		$stay_updated = "No";
	}
	
	if($rr['contact_date']!="0000-00-00 00:00:00" && $rr['contact_date']!="")
	{ 
		$contact_date = date("d-m-Y - h:i:s A", strtotime($rr['contact_date'])); 
	}else{ 
		$contact_date = ""; 
	}
	
	
		
	include $htmlfile."contactus_details.html";
?>
