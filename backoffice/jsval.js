/// This Function Is Used to check the File Extentions
 function start()
 {
	var st = parseInt(document.getElementById("state").length);
	for(i=st;i>0;i--)
	{
	 document.newuser.state.options[i] = null;
	}

	var st = parseInt(document.getElementById("city").length);
	for(i=st;i>0;i--)
	{
	 document.newuser.city.options[i] = null;
	}
 
 }
 function buildstate()
 {
	var st = parseInt(document.getElementById("state").length);
	
	var st1 = parseInt(document.getElementById("city").length);
	
	for(i=st;i>0;i--)
	{
	 document.newuser.state.options[i] = null;
	}

	for(i=st1;i>0;i--) 
	{
	 document.newuser.city.options[i] = null;
	}
	
	var i = document.getElementById("country");
	var b = i.value;
	eval("var a = con_arr"+b);


	var count = 1;
 
	for(k=0;k<a.length;k++)
	{
	 var txt = a[k];
	 var j = k+1;
	 var val = a[j];
	 var k = j;
	
	 eval ("document.getElementById('state').options["+count+"] = new Option('"+txt+"',"+val+")");
	 count = count + 1;
	}
	
 }  
 
 
 
  function buildcity()
 {
	var st = parseInt(document.getElementById("city").length);
	for(i=st;i>0;i--)
	{
	 document.newuser.city.options[i] = null;
	}
	
	var i = document.getElementById("state");
	var b = i.value;
	eval("var a = state_arr"+b);


	var count = 1;
 	for(k=0;k<a.length;k++)
	{
	 var txt = a[k];
	 var j = k+1;
	 var val = a[j];
	 var k = j;
	
	 eval ("document.getElementById('city').options["+count+"] = new Option('"+txt+"',"+val+")");
	 count = count + 1;
	}
 }  

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 function buildstate1()
 { 
	var st = parseInt(document.getElementById("state1").length);
	
	var st1 = parseInt(document.getElementById("city1").length);
	
	for(i=st;i>0;i--)
	{
	 document.newuser.state1.options[i] = null;
	}

	for(i=st1;i>0;i--)
	{
	 document.newuser.city1.options[i] = null;
	}
	
	var i = document.getElementById("country1");
	var b = i.value;
	eval("var a = con_arr"+b);


	var count = 1;
 
	for(k=0;k<a.length;k++)
	{
	 var txt = a[k];
	 var j = k+1;
	 var val = a[j];
	 var k = j;
	
	 eval ("document.getElementById('state1').options["+count+"] = new Option('"+txt+"',"+val+")");
	 count = count + 1;
	}
	
 }  
 
 
 
  function buildcity1()
 {
	var st = parseInt(document.getElementById("city1").length);
	for(i=st;i>0;i--)
	{
	 document.newuser.city1.options[i] = null;
	}
	
	var i = document.getElementById("state1");
	var b = i.value;
	eval("var a = state_arr"+b);


	var count = 1;
 	for(k=0;k<a.length;k++)
	{
	 var txt = a[k];
	 var j = k+1;
	 var val = a[j];
	 var k = j;
	
	 eval ("document.getElementById('city1').options["+count+"] = new Option('"+txt+"',"+val+")");
	 count = count + 1;
	}
 }  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function checkExt(FileName){
  
   if(document.getElementById(FileName).value!=""){
 
		 var ph_url = document.getElementById(FileName).value;
		 var start_pos = ph_url.lastIndexOf(".")+1;// this function gives the possition of "." in ph_ulr
		 var file_ext1 = ph_url.substring(start_pos);// this function gives the extention of file e.g .jpg , .txt .jpeg
		 var file_ext = file_ext1.toLowerCase();
		 
		 if(file_ext!="gif" && file_ext!="png" && file_ext!="jpg" && file_ext!="jpeg"){

			  alert("Please Select Only .jpeg OR .jpg OR .gif OR .png file. ");
			  return false;
		 }
       }//end of if
 
}//end of function checkExt()

function checkDate(){

  var day = document.getElementById("day").value ;
  var month = parseInt(document.getElementById("month").value) ;
  var year = document.getElementById("year").value ;
 
    switch(month){
 
     case 1: //Jan (31)
	         break;
	 case 2: //Feb (28/29)
 			   if(day==30 || day==31) {
			   
				 alert("Please Check Date You Have Seleted ! ! !");
				 return false
			   }//end of if
			   else{ 
				  
				  if(year%4!=0 && day > 28 && month==2){ /// Check ForLeap Year
				  
						 alert("Please Check Date You Have Seleted ! ! !");
						 return false
				  }//end of if
				  else{
				  }
			   }//end of else
	         break;		  
     case 3: //March (31)
	         break;
	 case 4: //April (30)
	 		 if(day==31){
				 alert("Please Check Date You Have Seleted ! ! !");
				 return false
			 }
	         break;		  
     case 5: //May (31)
	         break;
	 case 6: //June (30)
	 		 if(day==31){
				 alert("Please Check Date You Have Seleted ! ! !");
				 return false
			 }
	         break;
     case 7: //Jully (31)		  
	         break;
	 case 8: //Aug (31)
	         break;		  
     case 9: //Sep (30)
	 		 if(day==31){
				 alert("Please Check Date You Have Seleted ! ! !");
				 return false
			 }
	         break;
	 case 10: //Oct (31)
	         break;		  
     case 11: //Nove (30)
	 		 if(day==31){
				 alert("Please Check Date You Have Seleted ! ! !");
				 return false
			 }
	         break;
	 case 12://Dec (31)
	         break;		  
     default :
	          break ;
   }//end of switch
   
};

function goTopage(url){
 
  window.location=url;
};

function validateCompleteForm(objForm,strErrorClass){
return _validateInternal(objForm,strErrorClass,0);
};
function validateStandard(objForm,strErrorClass){
return _validateInternal(objForm,strErrorClass,1);
};
function _validateInternal(form,strErrorClass,nErrorThrowType){
var strErrorMessage="";var objFirstError=null;
if(nErrorThrowType==0){
strErrorMessage=(form.err)?form.err:_getLanguageText("err_form");
};
var fields=_GenerateFormFields(form);
for(var i=0;i<fields.length;++i){
var field=fields[i];
if(!field.IsValid(fields)){
field.SetClass(strErrorClass);
if(nErrorThrowType==1){
_throwError(field);
return false;
}else{
if(objFirstError==null){
objFirstError=field;
}
strErrorMessage=_handleError(field,strErrorMessage);
bError=true;
}
}else{
field.ResetClass();
}
};
if(objFirstError!=null){
alert(strErrorMessage);
objFirstError.element.focus();
return false;
};
return true;
};
function _getLanguageText(id){
objTextsInternal=new _jsVal_Language();
objTexts=null;
try{
objTexts=new jsVal_Language();
}catch(ignored){};
switch(id){
case "err_form":strResult=(!objTexts||!objTexts.err_form)?objTextsInternal.err_form:objTexts.err_form;break;
case "err_enter":strResult=(!objTexts||!objTexts.err_enter)?objTextsInternal.err_enter:objTexts.err_enter;break;
case "err_select":strResult=(!objTexts||!objTexts.err_select)?objTextsInternal.err_select:objTexts.err_select;break;
};
return strResult;
};
function _GenerateFormFields(form){
var arr=new Array();
for(var i=0;i<form.length;++i){
var element=form.elements[i];
var index=_getElementIndex(arr,element);
if(index==-1){
arr[arr.length]=new Field(element,form);
}else{
arr[index].Merge(element)
};
};
return arr;
};
function _getElementIndex(arr,element){
if(element.name){
var elementName=element.name.toLowerCase();
for(var i=0;i<arr.length;++i){
if(arr[i].element.name){
if(arr[i].element.name.toLowerCase()==elementName){
return i;
}
};
};
}
return -1;
};
function _jsVal_Language(){
this.err_form="Please enter/select values for the following fields:\n\n";
this.err_select="Please select a valid \"%FIELDNAME%\"";
this.err_enter="Please enter a valid \"%FIELDNAME%\"";
};
function Field(element,form){
this.type=element.type;
this.element=element;
this.exclude=element.exclude||element.getAttribute('exclude');
this.err=element.err||element.getAttribute('err');
this.required=_parseBoolean(element.required||element.getAttribute('required'));
this.realname=element.realname||element.getAttribute('realname');
this.elements=new Array();
switch(this.type){
case "textarea":
case "password":
case "text":
case "file":
this.value=element.value;
this.minLength=element.minlength||element.getAttribute('minlength');
this.maxLength=element.maxlength||element.getAttribute('maxlength');
this.regexp=this._getRegEx(element);
this.minValue=element.minvalue||element.getAttribute('minvalue');
this.maxValue=element.maxvalue||element.getAttribute('maxvalue');
this.equals=element.equals||element.getAttribute('equals');
this.callback=element.callback||element.getAttribute('callback');
break;
case "select-one":
case "select-multiple":
this.values=new Array();
for(var i=0;i<element.options.length;++i){
if(element.options[i].selected&&(!this.exclude||element.options[i].value!=this.exclude)){
this.values[this.values.length]=element.options[i].value;
}
}
this.min=element.min||element.getAttribute('min');
this.max=element.max||element.getAttribute('max');
this.equals=element.equals||element.getAttribute('equals');
break;
case "checkbox":
this.min=element.min||element.getAttribute('min');
this.max=element.max||element.getAttribute('max');
case "radio":
this.required=_parseBoolean(this.required||element.getAttribute('required'));
this.values=new Array();
if(element.checked){
this.values[0]=element.value;
}
this.elements[0]=element;
break;
};
};
Field.prototype.Merge=function(element){
var required=_parseBoolean(element.getAttribute('required'));
if(required){
this.required=true;
};
if(!this.err){
this.err=element.getAttribute('err');
};
if(!this.equals){
this.equals=element.getAttribute('equals');
};
if(!this.callback){
this.callback=element.getAttribute('callback');
};
if(!this.realname){
this.realname=element.getAttribute('realname');
};
if(!this.max){
this.max=element.getAttribute('max');
};
if(!this.min){
this.min=element.getAttribute('min');
};
if(!this.regexp){
this.regexp=this._getRegEx(element);
};
if(element.checked){
this.values[this.values.length]=element.value;
};
this.elements[this.elements.length]=element;
};
Field.prototype.IsValid=function(arrFields){
switch(this.type){
case "textarea":
case "password":
case "text":
case "file":
return this._ValidateText(arrFields);
case "select-one":
case "select-multiple":
case "radio":
case "checkbox":
return this._ValidateGroup(arrFields);
default:
return true;
};
};
Field.prototype.SetClass=function(newClassName){
if((newClassName)&&(newClassName!="")){
if((this.elements)&&(this.elements.length>0)){
for(var i=0;i<this.elements.length;++i){
if(this.elements[i].className!=newClassName){
this.elements[i].oldClassName=this.elements[i].className;
this.elements[i].className=newClassName;
}
}
}else{
if(this.element.className!=newClassName){
this.element.oldClassName=this.element.className;
this.element.className=newClassName;
}
};
}
};


Field.prototype.ResetClass=function(){
if((this.type!="button")&&(this.type!="submit")&&(this.type!="reset")){
  if((this.elements)&&(this.elements.length>0)){
    for(var i=0;i<this.elements.length;++i){
       if(this.elements[i].oldClassName){
         this.elements[i].className=this.elements[i].oldClassName;
       }
       else{
           this.element.className="combo_box";
       }
    }//end of for
  }else{
      if(this.elements.oldClassName){
         this.element.className=this.element.oldClassName;
        }
     else{
        this.element.className="combo_box";
     }
   };//end of else
 };//end of if
};//end of if

Field.prototype._getRegEx=function(element){
regex=element.regexp||element.getAttribute('regexp')
if(regex==null)return null;
retype=typeof(regex);
if(retype.toUpperCase()=="FUNCTION")
return regex;
else if((retype.toUpperCase()=="STRING")&&!(regex=="JSVAL_RX_EMAIL")&&!(regex=="JSVAL_RX_TEL")
&&!(regex=="JSVAL_RX_PC")&&!(regex=="JSVAL_RX_ZIP")&&!(regex=="JSVAL_RX_MONEY")
&&!(regex=="JSVAL_RX_CREDITCARD")&&!(regex=="JSVAL_RX_POSTALZIP"))
{
nBegin=0;nEnd=regex.length-1;
if(regex.charAt(0)=="/")nBegin=1;
if(regex.charAt(regex.length-1)=="/")nEnd=regex.length-2;
return new RegExp(regex.slice(nBegin,nEnd));
}
else{
return regex;
};
};
Field.prototype._ValidateText=function(arrFields){
if((this.required)&&(this.callback)){
nCurId=this.element.id?this.element.id:"";
nCurName=this.element.name?this.element.name:"";
eval("bResult = "+this.callback+"('"+nCurId+"', '"+nCurName+"', '"+this.value+"');");
if(bResult==false){
return false;
};
}else{
if(this.required&&!this.value){
return false;
};
if(this.value&&(this.minLength&&this.value.length<this.minLength)){
return false;
};
if(this.value&&(this.maxLength&&this.value.length>this.maxLength)){
return false;
};
if(this.regexp){
if(!_checkRegExp(this.regexp,this.value))
{
if(!this.required&&this.value){
return false;
}
if(this.required){
return false;
}
}
else
{
return true;
};
};
if(this.equals){
for(var i=0;i<arrFields.length;++i){
var field=arrFields[i];
if((field.element.name==this.equals)||(field.element.id==this.equals)){
if(field.element.value!=this.value){
return false;
};
break;
};
};
};
if(this.required){
var fValue=parseFloat(this.value);
if((this.minValue||this.maxValue)&&isNaN(fValue)){
return false;
};
if((this.minValue)&&(fValue<this.minValue)){
return false;
};
if((this.maxValue)&&(fValue>this.maxValue)){
return false
};
};
}
return true;
};
Field.prototype._ValidateGroup=function(arrFields){
if(this.required&&this.values.length==0){
return false;
};
if(this.required&&this.min&&this.min>this.values.length){
return false;
};
if(this.required&&this.max&&this.max<this.values.length){
return false;
};
return true;
};
function _handleError(field,strErrorMessage){
var obj=field.element;
strNewMessage=strErrorMessage+((field.realname)?field.realname:((obj.id)?obj.id:obj.name))+"\n";
return strNewMessage;
};
function _throwError(field){
var obj=field.element;
switch(field.type){
case "text":
case "password":
case "textarea":
case "file":
alert(_getError(field,"err_enter"));
try{
obj.focus();
}
catch(ignore){}
break;
case "select-one":
case "select-multiple":
case "radio":
case "checkbox":
alert(_getError(field,"err_select"));
break;
};
};
function _getError(field,str){
var obj=field.element;
strErrorTemp=(field.err)?field.err:_getLanguageText(str);
idx=strErrorTemp.indexOf("\\n");
while(idx>-1){
strErrorTemp=strErrorTemp.replace("\\n","\n");
idx=strErrorTemp.indexOf("\\n");
};
return strErrorTemp.replace("%FIELDNAME%",(field.realname)?field.realname:((obj.id)?obj.id:obj.name));
};
function _parseBoolean(value){
return !(!value||value==0||value=="0"||value=="false");
};
function _checkRegExp(regx,value){
switch(regx){
case "JSVAL_RX_EMAIL":
return((/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/).test(value));
case "JSVAL_RX_TEL":
return((/^1?[\-]?\(?\d{3}\)?[\-]?\d{3}[\-]?\d{4}$/).test(value));
case "JSVAL_RX_PC":
return((/^[a-z]\d[a-z]?\d[a-z]\d$/i).test(value));
case "JSVAL_RX_ZIP":
return((/^\d{5}$/).test(value));
case "JSVAL_RX_MONEY":
return((/^\d+([\.]\d\d)?$/).test(value));
case "JSVAL_RX_CREDITCARD":
return(!isNaN(value));
case "JSVAL_RX_POSTALZIP":
if(value.length==6||value.length==7)
return((/^[a-zA-Z]\d[a-zA-Z] ?\d[a-zA-Z]\d$/).test(value));
if(value.length==5||value.length==10)
return((/^\d{5}(\-\d{4})?$/).test(value));
break;
default:
return(regx.test(value));
};
};

