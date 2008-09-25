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

var TAB_DISABLED = 0;
var TAB_NORMAL = 1;
var TAB_ACTIVE = 2;
var we_name_z = 0;

function we_tab_write(){
	document.write(((this.state != TAB_DISABLED) ? '<a href="'+this.href+'" onClick="we_tabs['+this.z+'].setState(TAB_ACTIVE,false,we_tabs);'+this.js+';this.blur();">' : '') + '<img src="'+this.src+'" width="'+this.width+'" height="'+this.height+'" border="0" name="'+this.name+'">' + ((this.state != TAB_DISABLED) ? '</a>' : ''));
}

function we_tab_setState(state,init,objects){

	this.state = state;
	
	if(this.state == TAB_DISABLED){
		this.src = this.disabledSrc;
		imgObj = this.nameDisabled;
	}else if(this.state == TAB_ACTIVE){
		this.src = this.activeSrc;
		imgObj = this.nameActive;
	}else{
		this.src = this.normSrc;
		imgObj = this.nameNorm;
	}
	
	if(!init){
		changeImage(null,this.name,imgObj);
	}
	if(objects){
		for(var i=0; i<objects.length; i++){
			if(objects[i].state != TAB_DISABLED && this.z != i){
				objects[i].state = TAB_NORMAL;
				objects[i].src = objects[i].normSrc;
				changeImage(null,objects[i].name,objects[i].nameNorm);
			}
		}
	}
}

function we_tab(href,normSrc,activeSrc,disabledSrc,width,height,state,js){
	this.src="";
	this.href = href;
	this.normSrc=normSrc;
	this.activeSrc=activeSrc;
	this.disabledSrc=disabledSrc;
	this.width=width;
	this.height=height;
	this.name = "tab_"+we_name_z;
	this.nameNorm = "tabNorm_"+we_name_z;
	this.nameActive = "tabActive_"+we_name_z;
	this.nameDisabled = "tabDisabled_"+we_name_z;
	this.js=js;

	this.z = we_name_z;
	we_name_z++;
	this.setState = we_tab_setState;
	this.setState(state,true);
	
	preload(this.nameNorm,this.normSrc);
	preload(this.nameActive,this.activeSrc);
	preload(this.nameDisabled,this.disabledSrc);
	
	
	this.write = we_tab_write;
}
