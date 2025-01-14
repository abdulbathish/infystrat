<?php   	

	  function q($q_str,$dbconnect)
	  {    
		$r = @mysql_query($q_str, $dbconnect);
		return $r;
	  }
	
	  function d($dbconnect)
	  {
		@mysql_close($dbconnect);
	  }
	
	  function e($r)
	  {
	   if(@mysql_numrows($r))
		return 0;
	   else return 1;
	  }
	
	  function f($r){
		  return @mysql_fetch_array($r);
	  }

	 function nr($r){
	  return @mysql_num_rows($r);
	 }
	 
	 //-------------------For SEO FRIendly URL only---------//
	 function replace_bad($str,$id){
	 	//echo $str;
		$newstr=str_replace(" ","-",$str);
	 	//$newstr=str_replace("&","and",$newstr);
		$newstr=str_replace("&","",$newstr);
		$newstr=str_replace(",","",$newstr);
		$newstr=str_replace(".","",$newstr);
		$newstr=str_replace("?","",$newstr);
		$newstr=str_replace("@","",$newstr);
		$newstr=str_replace("!","",$newstr);
		$newstr=str_replace("~","",$newstr);
		$newstr=str_replace("'","",$newstr);
		$newstr=str_replace("$","",$newstr);
		$newstr=str_replace("%","",$newstr);
		$newstr=str_replace("^","",$newstr);
		$newstr=str_replace("*","",$newstr);
		$newstr=str_replace("(","",$newstr);
		$newstr=str_replace(")","",$newstr);
		$newstr=str_replace("|","",$newstr);
		$newstr=str_replace("\/","",$newstr);
		$newstr=str_replace("/","",$newstr);
		$newstr=str_replace('"',"",$newstr);
		$newstr=str_replace("#","",$newstr);
		$newstr=str_replace("+","",$newstr);
		$newstr=str_replace(":","",$newstr);

		$newstr=strtolower($newstr);
		$newstr=$newstr."-".$id;
		return $newstr;
	 }
	 function replace_url($str){
	
		$newstr=str_replace(" ","-",$str);
	 	//$newstr=str_replace("&","and",$newstr);
		$newstr=str_replace("&","",$newstr);
		$newstr=str_replace(",","",$newstr);
		$newstr=str_replace(".","",$newstr);
		$newstr=str_replace("?","",$newstr);
		$newstr=str_replace("@","",$newstr);
		$newstr=str_replace("!","",$newstr);
		$newstr=str_replace("~","",$newstr);
		$newstr=str_replace("'","",$newstr);
		$newstr=str_replace("$","",$newstr);
		$newstr=str_replace("%","",$newstr);
		$newstr=str_replace("^","",$newstr);
		$newstr=str_replace("*","",$newstr);
		$newstr=str_replace("(","",$newstr);
		$newstr=str_replace(")","",$newstr);
		$newstr=str_replace("|","",$newstr);
		$newstr=str_replace("\/","",$newstr);
		$newstr=str_replace("/","",$newstr);
		$newstr=str_replace('"',"",$newstr);
		$newstr=str_replace("#","",$newstr);
		$newstr=str_replace("+","",$newstr);
		$newstr=str_replace(":","",$newstr);

	 	$newstr=strtolower($newstr);
		return $newstr;
	 }
	 
	 function make_url($permaval,$page_title,$url_title,$file_name,$pageid)
	 {
	 	if($permaval=='title'){
			if($url_title!=""){	
				$hurl_name=replace_url($url_title);
			}else{
				$hurl_name=replace_url($page_title);
			}	
			$hurl_string=$hurl_name;				
		}else
		{
			$hurl_string="$file_name?pageid=".base64_encode($pageid);
		}	
		return $hurl_string;
	 }
	 //-------------------For SEO FRIendly URL only---------//

// start Encyption decription functions
$key = "H8OL9h4LhS23QGShIeRkI3Tf";
$iv = "bUjGDeTm";
$bit_check=8;

function encrypt($text,$key,$iv,$bit_check) {
$text_num =str_split($text,$bit_check);
$text_num = $bit_check-strlen($text_num[count($text_num)-1]);
for ($i=0;$i<$text_num; $i++) {$text = $text . chr($text_num);}
$cipher = mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
mcrypt_generic_init($cipher, $key, $iv);
$decrypted = mcrypt_generic($cipher,$text);
mcrypt_generic_deinit($cipher);
return base64_encode($decrypted);
}

function decrypt($encrypted_text,$key,$iv,$bit_check){
$cipher = mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
mcrypt_generic_init($cipher, $key, $iv);
$decrypted = mdecrypt_generic($cipher,base64_decode($encrypted_text));
mcrypt_generic_deinit($cipher);
$last_char=substr($decrypted,-1);
for($i=0;$i<$bit_check-1; $i++){
    if(chr($i)==$last_char){
        $decrypted=substr($decrypted,0,strlen($decrypted)-$i);
        break;
    }
}
return $decrypted;
}
// End Encyption decription functions

?>