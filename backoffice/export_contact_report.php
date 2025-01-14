<?php
	ob_start(); 
	session_start();

	include "../db/mysql.php";
	include "../db/config.php";
		
	$today_date = time();
	
	$sql = "select * from contactus order by cid desc";
	$qry = q($sql,$dbconnect);
		
	$out.="Sr.No., Name,  Email Id, Phone, Subject, Message, Contact Date\r\n";
	
	if(nr($qry)>0) 
	{	
		$i=1;
		while ($rr = f($qry))
		{
			$fname = str_replace(","," ",$rr['fname']);
			$subject = str_replace(","," ",$rr['subject']);
			
			$email = $rr['email'];
			
			if($rr['phone']!="")
			{
				$phone = $rr['phone'];
			}else{
				$phone = " -- ";
			}
								
			$message1 = str_replace(","," ",$rr['message']);
			$message = str_replace("\r\n"," ", $message1);
			
			$contact_date = date('d-m-Y',strtotime($rr['contact_date']));			
			
			$out.="$i, $fname, $email, $phone, $subject, $message, $contact_date \r\n";

			$i++;
			
		}//	while ($result = f($qry))	
	}//if(nr($qry)>0)
	
	$today_date = date("d-m-Y");
	$file_name = "Contactus_Report_".$today_date.".csv";

	header("Content-type: text/x-csv");
	header("Content-Disposition: attachment; filename=$file_name");
	echo $out;
	exit;
?>