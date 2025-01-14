	
	function GetXmlHttpObject(handler)
	{		
		var objXMLHttp=null    
		if (window.XMLHttpRequest)    
		{
			objXMLHttp=new XMLHttpRequest()    
		}   
		else if (window.ActiveXObject)    
		{
			objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")    
		}
		return objXMLHttp
	}

	function stateChanged()
	{
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")    
		{
		document.getElementById("txtResult").innerHTML= xmlHttp.responseText;    
		}    
		else 
		{
			//alert(xmlHttp.status);    
		}
	}

	function stateChanged1()
	{
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")    
		{
		document.getElementById("txtResult1").innerHTML= xmlHttp.responseText;    
		}    
		else 
		{
			//alert(xmlHttp.status);    
		}
	}
	function stateChanged2()
	{
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")    
		{
			document.getElementById("txtResult2").innerHTML= xmlHttp.responseText;    
		}    
		else 
		{
			//alert(xmlHttp.status);    
		}
	}
	
	
	// Will populate data based on input
	function htmlDatacity(url, qStr)
	{   		
		if (url.length==0)   
		{        
			document.getElementById("txtResult").innerHTML="";        
			return;    
		}
		
		xmlHttp=GetXmlHttpObject()    
		if (xmlHttp==null)    
		{        
			alert ("Browser does not support HTTP Request");        
			return;    
		}    
		
		url=url+"?"+qStr;     
		url=url+"&sid="+Math.random();   
		xmlHttp.onreadystatechange=stateChanged;    
		xmlHttp.open("GET",url,true) ;    
		xmlHttp.send(null);
	}

	function htmlDatacity1(url, qStr, mcat)
	{   		
		if (url.length==0)   
		{        
			document.getElementById("txtResult1").innerHTML="";        
			return;    
		}
		
		xmlHttp=GetXmlHttpObject()    
		if (xmlHttp==null)    
		{        
			alert ("Browser does not support HTTP Request");        
			return;    
		}    
		
		url=url+"?"+qStr+"&"+mcat;     
		url=url+"&sid="+Math.random();   
		
		xmlHttp.onreadystatechange=stateChanged1;    
		xmlHttp.open("GET",url,true) ;    
		xmlHttp.send(null);
	}

	function htmlDatacity2(url, qStr, scat)
	{   		
		if (url.length==0)   
		{        
			document.getElementById("txtResult1").innerHTML="";        
			return;    
		}
		
		xmlHttp=GetXmlHttpObject()    
		if (xmlHttp==null)    
		{        
			alert ("Browser does not support HTTP Request");        
			return;    
		}    
		
		url=url+"?"+qStr+"&"+scat;     
		url=url+"&sid="+Math.random();   
		//alert("URL : "+url);
		xmlHttp.onreadystatechange=stateChanged2;    
		xmlHttp.open("GET",url,true) ;    
		xmlHttp.send(null);
	}
	

