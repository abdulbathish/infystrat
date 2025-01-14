<?php
global $list,$day,$month,$year,$day_counter,$year_counter,$hour,$hr_counter,$min,$min_counter;
/**************************** Folloing are the Variable In which combo is built for Day & Date & Year*************/

	$list.="<option value=00>00</option>" ;
	$list.="<option value=01>01</option>" ;
	$list.="<option value=02>02</option>" ;
	$list.="<option value=03>03</option>" ;
	$list.="<option value=04>04</option>" ;
	$list.="<option value=05>05</option>" ;
	$list.="<option value=06>06</option>" ;
	$list.="<option value=07>07</option>" ;
	$list.="<option value=08>08</option>" ;
	$list.="<option value=09>09</option>" ;
	
/************************************ Build Day's List ************************************/
   for($day_counter=1; $day_counter <= 31; $day_counter++) 
      	  $day.="<option value=$day_counter>$day_counter</option>" ;
	     

	
/************************************ Build Month's List ************************************/  
      	  $month.="<option value='1'>January</option>" ;
		  $month.="<option value='2'>February</option>" ;
		  $month.="<option value='3'>March</option>" ;
      	  $month.="<option value='4'>April</option>" ;
		  $month.="<option value='5'>May</option>" ;
		  $month.="<option value='6'>Jun</option>" ;
      	  $month.="<option value='7'>July</option>" ;
		  $month.="<option value='8'>August</option>" ;
		  $month.="<option value='9'>September</option>" ;
      	  $month.="<option value='10'>October</option>" ;
		  $month.="<option value='11'>November</option>" ;
		  $month.="<option value='12'>December</option>" ;
		  
	     


/************************************ Build Year's List ************************************/  

   for($year_counter=2006; $year_counter <= 2029; $year_counter++) 
      	  $year.="<option value=$year_counter>$year_counter</option>" ;
	     


/************************************ Build Hour's List ************************************/  
   $hour.=$list ;
   for($hr_counter=10; $hr_counter <= 24; $hr_counter++) 
      	  $hour.="<option value=$hr_counter>$hr_counter</option>" ;


/************************************ Build Munit's List ************************************/  
   $min.=$list ;
   for($min_counter=10; $min_counter <= 60; $min_counter++) 
      	  $min.="<option value=$min_counter>$min_counter</option>" ;
	     


function day($SelectedDay){

/************************************ Build Day's List ************************************/
   for($day_counter=1; $day_counter <= 31; $day_counter++){
    	  
     $SelectedDay==$day_counter ? $day.="<option value=$day_counter selected>$day_counter</option>" 
	                            : 
								  $day.="<option value=$day_counter>$day_counter</option>" ;
	
	}//enf of for loop
	
	return 	$day ;  
	
}//end of function day()  

function month($SelectedMonth){

/************************************ Build Day's List ************************************/
   for($month_counter=1; $month_counter <= 12; $month_counter++){
    
	switch($month_counter){ 	  
	 
	  case 1:
	   		 $Monthname	= "January";	
	         break; 

	  case 2:
	         $Monthname	= "February";
	         break; 

	  case 3: $Monthname	= "March";
	         break; 

	  case 4: $Monthname	= "April";
	         break; 

	  case 5: $Monthname	= "May";
	         break; 

	  case 6: $Monthname	= "June";
	         break; 

	  case 7: $Monthname	= "July";
	         break; 

	  case 8: $Monthname	= "August";
	         break; 

	  case 9: $Monthname	= "September";
	         break; 

	  case 10: $Monthname	= "October";
	         break; 

	  case 11: $Monthname	= "November";
	         break; 
	  case 12:
	     	 $Monthname	= "December";
	         break; 

			 
	   
	}//end of switch
	
     $SelectedMonth==$month_counter ? $month.="<option value='$month_counter' selected>$Monthname</option>" 
	                            : 
								      $month.="<option value='$month_counter'>$Monthname</option>" ;
	
	
  }//enf of for loop
	
 return 	$month ;  
	
}//end of function month()  



function year($SelectedYear){

/************************************ Build Day's List ************************************/
   for($year_counter=2006; $year_counter <= 2029; $year_counter++){
    	  
     $SelectedYear==$year_counter ? $year.="<option value=$year_counter selected>$year_counter</option>" 
	                            : 
								   $year.="<option value=$year_counter>$year_counter</option>" ;
	
	}//enf of for loop
	
	return 	$year ;  
	
}//end of function year()  

function year1($SelectedYear){

/************************************ Build Day's List ************************************/
   for($year_counter1=2007; $year_counter1 >= 1907; $year_counter1--){
    	  
     $SelectedYear==$year_counter1 ? $year1.="<option value=$year_counter1 selected>$year_counter1</option>" 
	                            : 
								   $year1.="<option value=$year_counter1>$year_counter1</option>" ;
	
	}//enf of for loop
	
	return 	$year1 ;  
	
}//end of function year()  

function country($SelectedCounrey){

  $query = "select * from for_country";
  $re = q($query);
  while($re_sesult = f($re)){
  
     $SelectedCounrey==$re_sesult[id] ? $country.="<option value='$re_sesult[id]' selected>$re_sesult[country]</option>" 
	 								  :	$country.="<option value='$re_sesult[id]'>$re_sesult[country]</option>" ;
	 
  }//end of while
  
  return $country ;
  
}//end of function country()



function Shour($Selectedhour){
     
     $hr = array('00','01','02','03','04','05','06','07','08','09');

 	 for($hr_counter=10; $hr_counter <= 24; $hr_counter++) 
      	  $hr[]= $hr_counter ;
	 
	 for($HourCount=0 ; $HourCount<=24 ; $HourCount++){
     
	 $Selectedhour==$hr[$HourCount] ? $Hr.="<option value='$hr[$HourCount]' selected>$hr[$HourCount]</option>" 
	 								: 
									  $Hr.="<option value='$hr[$HourCount]'>$hr[$HourCount]</option>" ;
	 }//end of for
	 
     return $Hr ;

}//end of function Shour()

function Smin($Selectedmin){
     echo "HI ";
     $min = array('00','01','02','03','04','05','06','07','08','09');

 	 for($min_counter=10; $min_counter <= 60; $min_counter++) 
      	  $min[]= $min_counter ;
	 
	 for($MinCount=0 ; $MinCount<=60 ; $MinCount++){
     
	 $Selectedmin==$min[$MinCount] ? $Min.="<option value='$min[$MinCount]' selected>$min[$MinCount]</option>" 
	 								: 
									  $Min.="<option value='$min[$MinCount]'>$min[$MinCount]</option>" ;
	 }//end of for
	 
     return $Min ;

}//end of Smin


function Sampm($Sampm){
   
	if($Sampm=="am"){
	      
		    $ampm.="<option value='am' selected>am</option>" ;
			$ampm.="<option value='pm'>pm</option>" ;
	}//end of if
	
	else{
		    $ampm.="<option value='am'>am</option>" ;
			$ampm.="<option value='pm' selected>pm</option>" ;
			
	}//end of else		
	
  return $ampm ;
  
}//end of function Sampm()

?>
	  
