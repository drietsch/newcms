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

if(!we) var we={};
we.validate = {
	email:function(email){
		email = email.replace(/".*"/g,"y");
		email = email.replace(/\\./g,"z");
		var parts = email.split("@");
		if(parts.length!=2) return false;
		if(!we.validate.domain(parts[1])) return false;
		if(!parts[0].match(/(.+)/)) return false;
		return true;
	},
	domain:function(domain){
		var parts = domain.split(".");
		//if(parts.length>3 || parts.length<1) return false;
		//if(parts.length===1 && !we.validate.domainname(parts[0])) return false;
		for(var i=0; i< (parts.length-1); i++) {
			if(!we.validate.domainname(parts[i])) return false;
		}
		if(!parts[parts.length-1].match(/^[a-z][a-z]+$/i)) return false;
		return true;
	},
	domainname:function(domainname){
		
		var pattern = /^[^_\-\s/=?\*"'#!§$%&;()\[\]\{\};:,°<>\|][^\s/=?\*"'#!§$%&;()\[\]\{\};:,°<>\|]+$/i;
		if(domainname.match(pattern)) return true;
		return false;
	},
	date:function(){
		// TODO 
	},
	currency:function(){
		// TODO 
	}
	
}