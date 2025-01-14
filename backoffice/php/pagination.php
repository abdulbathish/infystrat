<?php

function Pagination($parent_page , $recordesPerPage , $totalNumberOfRecords , $lowerLimit, $CSSClass){

	 $CSSClass=="" ? $class = "pagelink" : $class =  $CSSClass ;
	$parent_page=str_replace(" ", "%20", "$parent_page");
	 $checkPage = strpos($parent_page,"?") ;
	 
	 $checkPage == "" ? $parent_page = $parent_page."?" : $parent_page = $parent_page."&" ;
	 
	 $Show_Page_Numbers_Flag = "ON"; // Turn "OFF" this flag to hide Page Numbers In Your List" ;
	 
	 $Show_Next_Prev_Flag = "ON"; // Turn "ON" this flag to Show "Prev" && "Next In Your List" ;
	 
	 $Show_Fisrt_Last_Flag = "OFF"; // Turn "ON" this flag to show "First" && "Last" In Your List" ;
	 
     $check_mod = $totalNumberOfRecords % $recordesPerPage ;
	 
	 $check_mod > 0 ?  @$totalNumberOfPages=($totalNumberOfRecords/$recordesPerPage)+1 : @$totalNumberOfPages=$totalNumberOfRecords / $recordesPerPage;
	
	 $lastpagenumber=$totalNumberOfPages;	
	 
     if($totalNumberOfPages == 0)
	      $totalNumberOfPages = 1 ;
   
	 $start=0;
	 
	 $lowerLimit == "" ? @$current_page_no = ( 0 / $recordesPerPage) + 1 
	                   : 
						 @$current_page_no = ( $lowerLimit / $recordesPerPage) + 1;
 
 
/////////////////////////////////////////////////    FIRST <> LAST     /////////////////////////////////////////////////
 if($Show_Fisrt_Last_Flag == "ON"){
        
	   $first = 0 ; 
	   
	   $Last = ($totalNumberOfPages * $recordesPerPage) - $recordesPerPage ;
        
	   $PageList.="<a href=$parent_page"."str=$first class='$class'>First</a>&nbsp;-&nbsp;<a href=$parent_page"."str=$Last class='$class'>Last</a>&nbsp;&nbsp;&nbsp;&nbsp;"  ;   	   
					   
 }//end of if "Show" Next && Prev



///////////////////////////////////////////////   PREVIOUS   ////////////////////////////////////////////////////////

 if($Show_Next_Prev_Flag == "ON"){
        
	   $prev = $lowerLimit - $recordesPerPage ; 
        
	   $lowerLimit <=0 ? $PageList.="<<&nbsp;" 
	                   : $PageList.="<a href=$parent_page"."str=$prev class='$class'>&lt;&lt;</a>&nbsp;"  ;   	   
					   
 }//end of if "Show" Next && Prev
     
 
 
///////////////////////////////////////////////        Page Numbers 1 2 3 4.....  ////////////////////////////////////// 
 if($Show_Page_Numbers_Flag == "ON"){

 	 if($totalNumberOfPages >9){
	 $totalNumberOfPages=10;
	 } 
	 for($counter = 1 ; $counter <= $totalNumberOfPages ; $counter++){

		$counter != 1 ? $PageList.="-" : $PageList.="" ;
		
		$counter == $current_page_no ?
		                       $PageList.="<b><a href=$parent_page"."str=$start style='color:orange; '>$counter</a></b>"
							  :
			                   $PageList.="<a href=$parent_page"."str=$start class='$class'>$counter</a>" ; 

			$start=$start+$recordesPerPage;
			
	 }//end of for
	 
  }//end of if "Show" Page Numbers
	 


///////////////////////////////////////////////        NEXT      //////////////////////////////////////////////////////// 
 if($Show_Next_Prev_Flag == "ON"){
       
	   $totalpages=substr($lastpagenumber,0,4);
	   $Last1 = ($totalpages * $recordesPerPage) - $recordesPerPage;

	   $next = $lowerLimit + $recordesPerPage ; 
       
	   if($lowerLimit=="")
	       $lowerLimit=0 ;
	   if($totalNumberOfPages >9){
	   $lowerLimit < $totalNumberOfRecords - $recordesPerPage ? 
	                                                            $PageList.=" ..... <a href=$parent_page"."str=$Last1 class='$class'>$totalpages</a> <a href=$parent_page"."str=$next class='$class'>&gt;&gt;</a>"   
															  :  
															     $PageList.=" &gt;&gt;" ;   	   
	   } else {
		 $lowerLimit < $totalNumberOfRecords - $recordesPerPage ? 
	                                                            $PageList.=" <a href=$parent_page"."str=$next class='$class'>&gt;&gt;</a>"   
															  :  
															     $PageList.=" &gt;&gt;" ;   	
	   }
	  	   
 }//end of if "Show" Next && Prev




	if($PageList=="")
	     $PageList="All Falges In <b>Pagination()</b> Function Are Set To <b>'OFF'</b>.  Please Turn <b>'ON'</b> any of them as per your need" ;
		 
	 return $PageList;
			
}//end of function Page()


                  //////////////////////////////  End Of Function Pagination() ////////////////////////////
			  

?>
