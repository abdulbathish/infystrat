function check_all(frm, chAll)
	{    
		comfList = document.forms[frm].elements['checkList[]'];    
		checkAll = (chAll.checked)?true:false; 
		if (comfList.length) {        
			if (checkAll) {            
					for (i = 0; i < comfList.length; i++) {                
						comfList[i].checked = true;            
					}        
				}        
				else {            
					for (i = 0; i < comfList.length; i++) {                
					comfList[i].checked = false;            
					}        
				}    
				}    
				else {        

				if (checkAll) {            
					comfList.checked = true;        
				}        
				else {            
					comfList.checked = false;        
			}    
		}    
		return;
	}

