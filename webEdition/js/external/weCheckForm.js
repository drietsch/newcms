/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

function weCheckFormEvent(){}

weCheckFormEvent.addEvent = function(e, name, f) {
    if (e.addEventListener) {
        e.addEventListener(
            name,
            f,
            true);
    }
    if(e.attachEvent){
        e.attachEvent("on" + name, f);
    }
}

weCheckFormEvent.stopEvent = function(ev) {
	if (ev.stopPropagation) {
		ev.preventDefault();
		ev.stopPropagation();
	} else {
    	ev.cancelBubble = true;
	    ev.returnValue = false;
    }
}


function initWeCheckForm_by_name(name){
    forms = document.getElementsByTagName("form");
    for(i=0;i<forms.length;i++){
        if(forms[i].name == name){
            weCheckFormEvent.addEvent(forms[i],"submit", eval("weCheckForm_n_" + name) );
            break;
        }
    }
}

function initWeCheckForm_by_id(id){
    formular = document.getElementById(id);
    weCheckFormEvent.addEvent(formular,"submit", eval("weCheckForm_id_" + id) );
}

function weCheckFormMandatory(form, reqFields){ //  return name of not set mandatory fields
    //  check required fields
    var missingFields = new Array();
    
    for(i=0;i<reqFields.length;i++){
    	
        ok = true;
        elem = form[reqFields[i]];
        
        if (elem && elem.type && elem.type == "checkbox") { // for checkbox
        	if (!elem.checked) {
        		ok = false;
        	}
        } else {
        	if(!elem || !elem.value){        //  text, password, select
        	
	            ok = false;
	            if(elem && elem.length){    //  perhaps it is a radio-button
	                for(j=0;j<elem.length;j++){
	                    if(elem[j].checked){
	                        ok = true;
	                    }
	                }
	            }
        	}
        }
        
        if(!ok){
            missingFields.push(reqFields[i]);
        }
    }
    return missingFields;
}

function weCheckFormEmail(form,emailFields){    //  return names of invalid email fields

    invalidEmails = new Array();

    if(emailFields.length > 0){
        
        pattern = "^([a-zA-Z0-9-הצü_\.]+)@([a-zA-Z0-9\-_\\.]+)\\.([a-zA-Z0-9]{2,4})";

        for(i=0;i<emailFields.length;i++){

            elem = formular[emailFields[i]];
            if(elem && elem.value){
                if(!elem.value.match(pattern)){
                    invalidEmails.push(emailFields[i]);
                }
            }
        }
    }
    return invalidEmails;
}

function weCheckFormPassword(form, pwFields){   //  return true in case of error

    if(form[pwFields[0]] && form[pwFields[1]] && pwFields[2]){
        
        f1 = form[pwFields[0]].value;
        f2 = form[pwFields[1]].value;
        f3 = pwFields[2];
        
        if( (f1 == f2) && (f1.length >= f3 ) ){
            return false;
        } else {
            return true;
        } 
    } else {
        return true;
    }
}