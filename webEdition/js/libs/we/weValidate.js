/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
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