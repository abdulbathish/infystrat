<script>

	// Fuction to move between two list

	// ------- Set Counter
	var currcntl;
	var fixcntl;
	var currcntr;

	function set_cntl(rcnt)
	{
		//alert(rcnt);
		currcntl = rcnt;
		fixcntl = rcnt;
	}	
	function set_cntr(rcnt)
	{
		//alert(rcnt);
		currcntr = rcnt;
	}
	
	// ----------- Function to move from left to right
	
	function move_right()
	{	
		//alert(fixcntl);
		if ((document.getElementById("lstsurgens").value != "")&&(document.getElementById("lstsurgens").value != "0"))
		{
			var test1 = document.getElementById("lstsurgens");
			for (var i = 0; i < test1.length; i++) 
			{
   				 if (test1.options[i].selected) 
				 {
					temp = document.getElementById("lstsurgens").options[i].text;
					tempval = document.getElementById("lstsurgens").options[i].value;
					document.getElementById('lstsurgenus').options[currcntl] = new Option(temp,tempval);
					currcntl++;
				}//if
			}//for
			for (var i = test1.length-1; i >= 0; i--) 
			{
				 if (test1.options[i].selected) 
			 	{
					document.getElementById("lstsurgens").options[i] = null;
					currcntr--;					
				}//if
			}//for
		}//if	
	}
	
	// ----------- Function to move from right to left
	
function move_left1()
{

	if ((document.getElementById("lstsurgenus").value != "")&&(document.getElementById("lstsurgenus").value != "0"))
	{ 
		var test1 = document.getElementById("lstsurgenus");
		if (test1.selectedIndex >= fixcntl)
		{
			for (var i = 0; i < test1.length; i++) 
			{
				if (test1.options[i].selected) 
				{
					temp = document.getElementById("lstsurgenus").options[i].text;
					tempval = document.getElementById("lstsurgenus").options[i].value;
					document.getElementById('lstsurgens').options[currcntr] = new Option(temp,tempval);
					currcntr++;
				}
			}
			for (var i = test1.length-1; i >= 0; i--) 
			{
				if(test1.options[i].selected) 
				{
					document.getElementById("lstsurgenus").options[test1.selectedIndex] = null;
					currcntl--;
				}//if
				
			}//for 
			
		}
		else
		{ alert("Can't Remove !! "); }
	}
}
	
	function move_left()
	{
		
		if ((document.getElementById("lstsurgenus").value != "")&&(document.getElementById("lstsurgenus").value != "0"))
		{
			var test1 = document.getElementById("lstsurgenus");
			for (var i = 0; i < test1.length; i++) 
			{
   				 if (test1.options[i].selected) 
				 {
					temp = document.getElementById("lstsurgenus").options[i].text;
					tempval = document.getElementById("lstsurgenus").options[i].value;
					document.getElementById('lstsurgens').options[currcntr] = new Option(temp,tempval);
					currcntr++;
			     }//if
			}//for
			for (var i = test1.length-1; i >= 0; i--) 
			{
				 if (test1.options[i].selected) 
			 	{
					document.getElementById("lstsurgenus").options[test1.selectedIndex] = null;
					currcntl--;		
				}//if
			}//for
		}//if
	}
	
	// ----------- Function to move all from left to right
	
	function move_all()
	{
		rcnt = 	document.getElementById("lstsurgens").length;
		//alert(rcnt);
		for (m=0;m<=rcnt-1;m++)
		{
			//alert(m);
		
			temp = document.getElementById("lstsurgens").options[0].text;
			tempval = document.getElementById("lstsurgens").options[0].value;
			//alert(temp);
			document.getElementById("lstsurgens").options[0] = null;				
			currcntr--;
			document.getElementById('lstsurgenus').options[currcntl] = new Option(temp,tempval);
			currcntl++;
		}
	}
	
	// ----------- Function to copy values in text box
	
	function get_val()
	{
		document.getElementById("txtlsts").value = "";
		for(i=0;i<currcntl;i++)
		{
			l = document.getElementById("lstsurgenus").options[i].value;
			document.getElementById("txtlsts").value = l + "," + document.getElementById("txtlsts").value;
		}
		k = document.getElementById("txtlsts").value;
		//alert(k);
	}
	
	function ChkMe()
	{
		  var sel = document.getElementById("lstsurgenus").value;
		  if(sel=="") 
		  {
		  		alert("Select atleast one member");
				return false;
		  }
	}
	 
	function showMail()
	{
		window.open('showmail.php','Newsletter Content','width=500,height=500,resizable=no,scrollbars=no');
	} 
	 	 
</script>
<?php

		$sel_mem  = q("select * from tblnewsletter where fldemail!='' and fldsubscribe=1 order by fldid",$dbconnect);
		echo ("<script>set_cntr(".nr($sel_mem).")</script>");
		echo ("<script>set_cntl('0')</script>");
		 if(nr($sel_mem)>0)
		 { 
			while($rs_mem = f($sel_mem))
				$lstmember .= "<option value = $rs_mem[fldid]>".ucwords($rs_mem['fldemail'])."</option>";
		 }

		 $mail_id = "select * from contactus_mail where id='5'";
		 $res_mail = q($mail_id,$dbconnect);
		 $row_mail = f($res_mail);
		 $mail_from = $row_mail['mail_from'];
		  		 		 
	 	$tbl .= "<form name='form1' method='post' action='' onsubmit = 'get_val()'>";
        $tbl .= "<table width='100%' border='0' cellspacing='0' cellpadding='6'>";
		$tbl .= "<tr>";
		$tbl .= "<td class='admin_head' colspan=2><input type = 'submit' name = 'btnSendToAll' value = 'Send Newsletter To All'   class='input-button'></td>";
		$tbl .= "<td align='right' class='admin_head'><a href='index.php?page=mail_details'><strong>Draft Newsletter Content </strong></a></td>";
  		$tbl .= "</tr>";
		
		$tbl .= "<tr>";
		$tbl .= "<td rowspan='3'><b>List of Members(s)</b><br><br>";
		$tbl .= "<select name='lstsurgens' id='lstsurgens' size='15' style  = 'width:250px' ";
		$tbl .= " ondblclick = 'move_right()'";
		$tbl .= " multiple>";
		$tbl .= $lstmember;
        $tbl .= "</select></td>";
		
		$tbl .= "<td align='center' valign='bottom'>";
        $tbl .= "<input type='button' name='ButtonF' value='&gt;&gt;' onclick = 'move_right()' class='input-button'>";
        $tbl .= "</td>";
		$tbl .= "<td rowspan='3' width='41%'><b>Selected Member(s)</b><br><br>";
        $tbl .= "<select name='lstsurgenus' id='lstsurgenus' size='15' style  = 'width:250px' ";
		$tbl .= "ondblclick = 'move_left()'";		
		$tbl .= " multiple>";
		$tbl .=  lstSurgeonSelected;
        $tbl .= "</select></td>";
        $tbl .= "</tr>";
		$tbl .= "<tr>" ;
		$tbl .= "<td height='25%' align='center' valign='top' width='20%'>";
		$tbl .= "<input type='button' name='ButtonF' value='&lt;&lt;' onclick = 'move_left()' class='input-button'>";
		$tbl .= "</td></tr>";
		
		$tbl .= "<tr>" ;
        $tbl .= "<td height='25%' align='center' valign='top' width='20%'>";
        $tbl .= "<input type='button' name='ButtonF' value='Select all' onclick = 'move_all()' class='input-button'>";
        $tbl .= "</td></tr>";
		
		$tbl .= "<tr>" ;		
        $tbl .= "<td align='center' valign='top' colspan = 3>";
        $tbl .= " <input type = 'hidden' name = 'txtlsts' id = 'txtlsts'><input type = 'submit' name = 'submitlat' value = 'Send Newsletter To Selected'  class='input-button'>";//onClick='return ChkMe();'
        $tbl .= "</td></tr>";
		$tbl .= "</table></form>";
		
		
		// -------------- Send to selected member --------------
	 if(isset($_POST[submitlat]))
	 { 
	   	      
			     $sel_nw = q("select * from tblmail_message where fldid='1'",$dbconnect);
				 if(nr($sel_nw)>0)
				    $rs_mail_msg = f($sel_nw);
				    $mail_description = $rs_mail_msg['flddescription'];
				    $title = $rs_mail_msg['fldtitle'];
							  	 			
			 $uid = $_POST['txtlsts'];
			 $uid = substr($uid,0,-1);
			   
			 $msg.="<table cellSpacing='0' cellPadding='7' width='80%' align='center' border='0'>";
			 $msg.="<tr><td>";
			 $msg.="<font face=Verdana,Arial,Helvetica size=1>"; 
			 $msg.="Your newsletter from www.bestbrandsever.com <br> $mail_description ";  
			 $msg.="</font></td></tr>"; 
			  
	  		 
			 $msg.="</table>"; 
			 $msg.="</html>"; 
			 	
			 $headers  = "MIME-Version: 1.0\r\n"; 
			 $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			 $headers .= "From: Best Brands Ever<$mail_from>\r\n"; 
			     
			 
			    
			 $sel_mem  = q("select * from tblnewsletter where fldid in ($uid)",$dbconnect);
			 if(nr($sel_mem)>0)
			 {  
			 	while($rs_mem = f($sel_mem))
				{  
				      $unsubscribe="";
					  $mail_to = $rs_mem['fldemail']; 
					  $imgpath = "http://www.bestbrandsever.com/";     				
					  $mem_dtl = "<table width='100%' border='0' align='center' bgcolor='#000000' ><tr><td> </td></tr></table><table width='80%' border='0' cellpadding=7 align='center'><tr><td>Dear <b>".ucwords($rs_mem[fldemail]).",</b></td></tr></table>";   		  	 	  				
					 // $unsubscribe ="<table width='80%' border='0' align='center' cellpadding=7><tr><td><a href='http://www.vizteksoft.com/ocb/unsubscribe.php?id=$rs_mem[id]&mode=us'>Click here to unsubscribe newsletter</a></td></tr></table>"; 			 					     
					  $mess = "<div class='border_3sides'>".$mem_dtl." ".$msg."<br </div>"; 
					  
					  $mailme = @mail($mail_to,$title,$mess,$headers);  
					  
					  //$mail_me = mail_attachment("$mai_id","$to","$sub","$mess","$destination_main"); 
					  //$mailme = mail($mail_to,$title,$msg,$headers);  
					  //echo  $mess ;
					  
				}
				if($mailme)
					echo "<script>window.location='index.php?page=send_mail&msg=Newsletter Sent Successfully !'</script>";
				else
				    echo "<script>window.location='index.php?page=send_mail&msg=Newsletter Not Sent. Try Again!'</script>";	
			}		 
	 }
	  
	//------------- Send Newsletter To all ---------------//
	
	 if(isset($_POST[btnSendToAll]))
	 {  
			     $sel_nw = q("select * from tblmail_message where fldid='1'",$dbconnect);
				 if(nr($sel_nw)>0)
				    $rs_mail_msg = f($sel_nw);
				    $mail_description = $rs_mail_msg['flddescription'];
				    $title = $rs_mail_msg['fldtitle'];
							  	 			
			 $uid = $_POST['txtlsts'];
			 $uid = substr($uid,0,-1);
			   
			 $mesg.="<table cellSpacing='0' cellPadding='7' width='80%' align='center' border='0'>";
			 $mesg.="<tr><td>";
			 $mesg.="<font face=Verdana,Arial,Helvetica size=1>"; 
			 $mesg.="Your newsletter from www.bestbrandsever.com <br> $mail_description ";  
			 $mesg.="</font></td></tr>"; 
			  
	  		// $msg.="<tr><td>Thanks & regards<br>admin@cardealer.com</td></tr>"; 	
			 $mesg.="</table>"; 
			 $mesg.="</html>"; 
			 	
			 $headers  = "MIME-Version: 1.0\r\n"; 
			 $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			 $headers .= "From: Best Brands Ever<$mail_from>\r\n"; 
			    
			 //echo $msg;  
			    
			 $sel_mem  = q("select * from tblnewsletter",$dbconnect);
			 if(nr($sel_mem)>0)
			 {  
			 	while($rs_mem = f($sel_mem))
				{  
				      $unsubscribe="";
					  $mail_to = $rs_mem['fldemail']; 
					  $imgpath = "http://www.bestbrandsever.com/";     				
					  $mem_dtl = "<table width='100%' border='0' align='center' bgcolor='#000000' ><tr><td> </td></tr></table><table width='80%' border='0' cellpadding=7 align='center'><tr><td>Dear <b>".ucwords($rs_mem['first_name']).",</b></td></tr></table>";   		  	 	  				
					 			     
					  $mess = "<div class='border_3sides'>".$mem_dtl." ".$mesg."<br </div>"; 
					 
					  $mailme = mail($mail_to,$title,$mess,$headers); 
					 
					  
				} 
				 
				if($mailme)
					echo "<script>window.location='index.php?page=send_mail&msg=Newsletter Sent Successfully !'</script>";
				else
				    echo "<script>window.location='index.php?page=send_mail&msg=Newsletter Not Sent. Try Again!'</script>";	
			}		   
	 }
  
?>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="table_border">
	<tr>
		<th colspan="2" align="left" class="table_title">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr class="table_title">
		<td align="left">Send Newsletter</td>
		<td align="right" style="padding-right:5px;"><a href="index.php?page=newsletter_management" style="color:#FFFFFF;">&laquo; Back</a></td>
		</tr>
		</table>
 </th>
	</tr>
	 <? if($_GET['msg']!='') { ?>
	  <tr>
		<th class="admin_success_msg" height=22 colspan="2" align="center"><?php echo $_GET[msg]?></th>		
	  </tr>
	  <? } ?>
	  <? if($_GET['msg_error']!='') { ?>
	  <tr>
		<th class="admin_error_msg" height=22 colspan="2" align="center"><?php echo $_GET[msg_error]?></th>		
	  </tr>
	  <? } ?>
	
	<tr>
		<td colspan="2" ><? echo $tbl; ?> </td>
	</tr>	 
</table>
